<?php

declare(strict_types=1);

/*
 * This file is part of composer/satis.
 *
 * (c) Composer <https://github.com/composer>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Composer\Satis\Console\Command;

use Composer\Config;
use Composer\Factory;
use Composer\IO\NullIO;
use Composer\Repository\ConfigurableRepositoryInterface;
use Composer\Repository\RepositoryManager;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;

class BuildCommandTest extends TestCase
{
    /** @var array<string, array<string, mixed>> */
    private static array $savedDefaultRepositories;

    public static function setUpBeforeClass(): void
    {
        self::$savedDefaultRepositories = Config::$defaultRepositories;
    }

    protected function setUp(): void
    {
        unset(Config::$defaultRepositories['packagist'], Config::$defaultRepositories['packagist.org']);
    }

    protected function tearDown(): void
    {
        Config::$defaultRepositories = self::$savedDefaultRepositories;
    }

    /**
     * @return array<string, mixed>
     */
    public static function dataRepositoryDisableDirectives(): array
    {
        $data = [];

        $data['packagist.org disable only'] = [
            0,
            [
                ['packagist.org' => false],
            ],
        ];

        $data['packagist.org disable with valid repos'] = [
            2,
            [
                ['packagist.org' => false],
                [
                    'type' => 'package',
                    'package' => [
                        'name' => 'vendor/alpha',
                        'version' => '1.0.0',
                        'dist' => ['url' => 'https://example.com/alpha.zip', 'type' => 'zip'],
                    ],
                ],
                [
                    'type' => 'package',
                    'package' => [
                        'name' => 'vendor/beta',
                        'version' => '2.0.0',
                        'dist' => ['url' => 'https://example.com/beta.zip', 'type' => 'zip'],
                    ],
                ],
            ],
        ];

        $data['multiple disable directives'] = [
            1,
            [
                ['packagist.org' => false],
                ['my-private-repo' => false],
                [
                    'type' => 'package',
                    'package' => [
                        'name' => 'vendor/gamma',
                        'version' => '1.0.0',
                        'dist' => ['url' => 'https://example.com/gamma.zip', 'type' => 'zip'],
                    ],
                ],
            ],
        ];

        $data['disable directive at end'] = [
            1,
            [
                [
                    'type' => 'package',
                    'package' => [
                        'name' => 'vendor/delta',
                        'version' => '1.0.0',
                        'dist' => ['url' => 'https://example.com/delta.zip', 'type' => 'zip'],
                    ],
                ],
                ['packagist.org' => false],
            ],
        ];

        $data['no disable directives'] = [
            2,
            [
                [
                    'type' => 'package',
                    'package' => [
                        'name' => 'vendor/alpha',
                        'version' => '1.0.0',
                        'dist' => ['url' => 'https://example.com/alpha.zip', 'type' => 'zip'],
                    ],
                ],
                [
                    'type' => 'package',
                    'package' => [
                        'name' => 'vendor/beta',
                        'version' => '2.0.0',
                        'dist' => ['url' => 'https://example.com/beta.zip', 'type' => 'zip'],
                    ],
                ],
            ],
        ];

        return $data;
    }

    /**
     * Reproduces the repository iteration logic from BuildCommand::execute()
     * to verify that disable directives are skipped and valid repos are added.
     *
     * Without the fix, configs containing {"packagist.org": false} would throw
     * "Undefined array key 'type'"
     *
     * @param array<int, array<string, mixed>> $repositories
     */
    #[DataProvider('dataRepositoryDisableDirectives')]
    public function testRepositoryLoopSkipsDisableDirectives(int $expectedRepoCount, array $repositories): void
    {
        $config = [
            'name' => 'test/satis-repo',
            'homepage' => 'https://example.com',
            'repositories' => $repositories,
        ];

        $composer = (new Factory())->createComposer(new NullIO(), $config, true, null, false);
        $manager = $composer->getRepositoryManager();

        $initialCount = count($manager->getRepositories());

        $disabledRepoNames = [];
        foreach ($config['repositories'] as $repo) {
            if (!isset($repo['type']) && 1 === count($repo) && false === current($repo)) {
                $disabledRepoNames[] = key($repo);
                continue;
            }
            if (!isset($repo['type'])) {
                continue;
            }
            $manager->addRepository($manager->createRepository($repo['type'], $repo));
        }
        if ([] !== $disabledRepoNames) {
            $this->invokeRemoveDisabledRepositories($manager, $disabledRepoNames);
        }

        $addedRepos = count($manager->getRepositories()) - $initialCount;
        self::assertSame($expectedRepoCount, $addedRepos);
    }

    /**
     * Proves the disable directive has a functional effect: when packagist is
     * in the RepositoryManager's defaults, {"packagist.org": false} removes it.
     *
     * The Composer instance is created WITHOUT the directive (so packagist
     * survives Factory initialization), then the directive is applied after
     * the fact -- matching how BuildCommand processes it in plugin mode.
     */
    public function testDisableDirectiveRemovesPackagistFromRepositoryManager(): void
    {
        Config::$defaultRepositories = [
            'packagist.org' => ['type' => 'composer', 'url' => 'https://repo.packagist.org'],
        ];

        $configWithoutDirective = [
            'name' => 'test/satis-repo',
            'homepage' => 'https://example.com',
            'repositories' => [
                [
                    'type' => 'package',
                    'package' => [
                        'name' => 'vendor/test',
                        'version' => '1.0.0',
                        'dist' => ['url' => 'https://example.com/test.zip', 'type' => 'zip'],
                    ],
                ],
            ],
        ];

        $composer = (new Factory())->createComposer(new NullIO(), $configWithoutDirective, true, null, false);
        $manager = $composer->getRepositoryManager();

        self::assertTrue(
            $this->repositoryManagerContainsPackagist($manager),
            'Packagist should be present before processing disable directive'
        );

        $this->invokeRemoveDisabledRepositories($manager, ['packagist.org']);

        self::assertFalse(
            $this->repositoryManagerContainsPackagist($manager),
            'Packagist should be removed after processing disable directive'
        );
    }

    /**
     * Counterpart: without the disable directive, packagist remains.
     */
    public function testPackagistRemainsWithoutDisableDirective(): void
    {
        Config::$defaultRepositories = [
            'packagist.org' => ['type' => 'composer', 'url' => 'https://repo.packagist.org'],
        ];

        $config = [
            'name' => 'test/satis-repo',
            'homepage' => 'https://example.com',
            'repositories' => [
                [
                    'type' => 'package',
                    'package' => [
                        'name' => 'vendor/test',
                        'version' => '1.0.0',
                        'dist' => ['url' => 'https://example.com/test.zip', 'type' => 'zip'],
                    ],
                ],
            ],
        ];

        $composer = (new Factory())->createComposer(new NullIO(), $config, true, null, false);
        $manager = $composer->getRepositoryManager();

        foreach ($config['repositories'] as $repo) {
            $manager->addRepository($manager->createRepository($repo['type'], $repo));
        }

        self::assertTrue(
            $this->repositoryManagerContainsPackagist($manager),
            'Packagist should remain when no disable directive is present'
        );
    }

    /**
     * Verifies that removing disabled repositories produces verbose output
     * listing each removed repository name.
     */
    public function testRemoveDisabledRepositoriesOutputsInVerboseMode(): void
    {
        Config::$defaultRepositories = [
            'packagist.org' => ['type' => 'composer', 'url' => 'https://repo.packagist.org'],
        ];

        $config = [
            'name' => 'test/satis-repo',
            'homepage' => 'https://example.com',
            'repositories' => [],
        ];

        $composer = (new Factory())->createComposer(new NullIO(), $config, true, null, false);
        $manager = $composer->getRepositoryManager();

        self::assertTrue($this->repositoryManagerContainsPackagist($manager));

        $output = new BufferedOutput();
        $this->invokeRemoveDisabledRepositories($manager, ['packagist.org'], $output, true);

        self::assertFalse($this->repositoryManagerContainsPackagist($manager));
        self::assertStringContainsString(
            'Removed repository packagist.org (disabled by config)',
            $output->fetch()
        );
    }

    /**
     * Verifies that no output is produced in non-verbose mode.
     */
    public function testRemoveDisabledRepositoriesSilentInNonVerboseMode(): void
    {
        Config::$defaultRepositories = [
            'packagist.org' => ['type' => 'composer', 'url' => 'https://repo.packagist.org'],
        ];

        $config = [
            'name' => 'test/satis-repo',
            'homepage' => 'https://example.com',
            'repositories' => [],
        ];

        $composer = (new Factory())->createComposer(new NullIO(), $config, true, null, false);
        $manager = $composer->getRepositoryManager();

        $output = new BufferedOutput();
        $this->invokeRemoveDisabledRepositories($manager, ['packagist.org'], $output, false);

        self::assertSame('', $output->fetch());
    }

    /**
     * @param string[] $disabledRepoNames
     */
    private function invokeRemoveDisabledRepositories(RepositoryManager $manager, array $disabledRepoNames, ?\Symfony\Component\Console\Output\OutputInterface $output = null, bool $verbose = false): void
    {
        $command = new BuildCommand();
        $method = new \ReflectionMethod($command, 'removeDisabledRepositories');
        $method->invokeArgs($command, [$manager, $disabledRepoNames, $output ?? new NullOutput(), $verbose]);
    }

    private function repositoryManagerContainsPackagist(RepositoryManager $manager): bool
    {
        foreach ($manager->getRepositories() as $repo) {
            if ($repo instanceof ConfigurableRepositoryInterface) {
                $url = $repo->getRepoConfig()['url'] ?? '';
                if (1 === preg_match('{^https?://(?:[a-z0-9-.]+\.)?packagist\.org(/|$)}i', $url)) {
                    return true;
                }
            }
        }

        return false;
    }
}
