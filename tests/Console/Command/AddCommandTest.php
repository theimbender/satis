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

use Composer\Console\Application;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

#[TestDox('AddCommand')]
class AddCommandTest extends TestCase
{
    private string $configPath;

    protected function setUp(): void
    {
        vfsStream::setup('satis');
        $this->configPath = vfsStream::url('satis/satis.json');
    }

    private function createTester(bool $repoValid = true): CommandTester
    {
        $command = $this->getMockBuilder(AddCommand::class)
            ->onlyMethods(['isRepositoryValid'])
            ->getMock();
        $command->method('isRepositoryValid')->willReturn($repoValid);

        $app = new Application();
        $app->addCommand($command);

        return new CommandTester($app->find('add'));
    }

    /** @param array<string, mixed> $config */
    private function writeConfig(array $config): void
    {
        file_put_contents(
            $this->configPath,
            json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }

    /** @return array<string, mixed> */
    private function readConfig(): array
    {
        $contents = file_get_contents($this->configPath);
        self::assertIsString($contents);

        return json_decode($contents, true);
    }

    #[TestDox('Rejects an HTTP URL as the config file path')]
    public function testRejectsHttpConfigFile(): void
    {
        $tester = $this->createTester();
        $tester->execute(['url' => 'https://github.com/foo/bar.git', 'file' => 'http://example.com/satis.json']);

        self::assertSame(2, $tester->getStatusCode());
        self::assertStringContainsString('Unable to write to remote file', $tester->getDisplay());
    }

    #[TestDox('Rejects an HTTPS URL as the config file path')]
    public function testRejectsHttpsConfigFile(): void
    {
        $tester = $this->createTester();
        $tester->execute(['url' => 'https://github.com/foo/bar.git', 'file' => 'https://example.com/satis.json']);

        self::assertSame(2, $tester->getStatusCode());
        self::assertStringContainsString('Unable to write to remote file', $tester->getDisplay());
    }

    #[TestDox('Rejects a config file that does not exist')]
    public function testRejectsNonExistentFile(): void
    {
        $tester = $this->createTester();
        $tester->execute(['url' => 'https://github.com/foo/bar.git', 'file' => vfsStream::url('satis/nonexistent.json')]);

        self::assertSame(1, $tester->getStatusCode());
        self::assertStringContainsString('File not found', $tester->getDisplay());
    }

    #[TestDox('Rejects an invalid repository URL')]
    public function testRejectsInvalidRepository(): void
    {
        $this->writeConfig(['name' => 'test/repo', 'repositories' => []]);
        $tester = $this->createTester(repoValid: false);
        $tester->execute(['url' => 'https://github.com/foo/bar.git', 'file' => $this->configPath]);

        self::assertSame(3, $tester->getStatusCode());
        self::assertStringContainsString('Invalid Repository URL', $tester->getDisplay());
    }

    #[TestDox('Rejects a repository URL that already exists in the config')]
    public function testRejectsDuplicateUrl(): void
    {
        $this->writeConfig([
            'name' => 'test/repo',
            'repositories' => [
                ['type' => 'vcs', 'url' => 'https://github.com/foo/bar.git'],
            ],
        ]);
        $tester = $this->createTester();
        $tester->execute(['url' => 'https://github.com/foo/bar.git', 'file' => $this->configPath]);

        self::assertSame(4, $tester->getStatusCode());
        self::assertStringContainsString('Repository url already added to the file', $tester->getDisplay());
    }

    #[TestDox('Rejects a repository name that already exists in the config')]
    public function testRejectsDuplicateName(): void
    {
        $this->writeConfig([
            'name' => 'test/repo',
            'repositories' => [
                ['type' => 'vcs', 'url' => 'https://github.com/existing/repo.git', 'name' => 'my/package'],
            ],
        ]);
        $tester = $this->createTester();
        $tester->execute([
            'url' => 'https://github.com/foo/bar.git',
            'file' => $this->configPath,
            '--name' => 'my/package',
        ]);

        self::assertSame(5, $tester->getStatusCode());
        self::assertStringContainsString('Repository name already added to the file', $tester->getDisplay());
    }

    #[TestDox('Adds a repository to an empty config')]
    public function testAddRepositoryToEmptyConfig(): void
    {
        $this->writeConfig(['name' => 'test/repo', 'repositories' => []]);
        $tester = $this->createTester();
        $tester->execute(['url' => 'https://github.com/foo/bar.git', 'file' => $this->configPath]);

        self::assertSame(0, $tester->getStatusCode());
        self::assertStringContainsString('successfully updated', $tester->getDisplay());

        $config = $this->readConfig();
        self::assertCount(1, $config['repositories']);
        self::assertSame('vcs', $config['repositories'][0]['type']);
        self::assertSame('https://github.com/foo/bar.git', $config['repositories'][0]['url']);
    }

    #[TestDox('Includes the name field when --name is provided')]
    public function testAddRepositoryWithName(): void
    {
        $this->writeConfig(['name' => 'test/repo', 'repositories' => []]);
        $tester = $this->createTester();
        $tester->execute([
            'url' => 'https://github.com/foo/bar.git',
            'file' => $this->configPath,
            '--name' => 'foo/bar',
        ]);

        self::assertSame(0, $tester->getStatusCode());

        $config = $this->readConfig();
        self::assertSame('foo/bar', $config['repositories'][0]['name']);
    }

    #[TestDox('Omits the name field when --name is not provided')]
    public function testAddRepositoryWithoutName(): void
    {
        $this->writeConfig(['name' => 'test/repo', 'repositories' => []]);
        $tester = $this->createTester();
        $tester->execute(['url' => 'https://github.com/foo/bar.git', 'file' => $this->configPath]);

        self::assertSame(0, $tester->getStatusCode());

        $config = $this->readConfig();
        self::assertArrayNotHasKey('name', $config['repositories'][0]);
    }

    #[TestDox('Preserves existing repositories when adding a new one')]
    public function testAddRepositoryPreservesExistingRepos(): void
    {
        $this->writeConfig([
            'name' => 'test/repo',
            'repositories' => [
                ['type' => 'vcs', 'url' => 'https://github.com/existing/repo.git'],
            ],
        ]);
        $tester = $this->createTester();
        $tester->execute(['url' => 'https://github.com/foo/bar.git', 'file' => $this->configPath]);

        self::assertSame(0, $tester->getStatusCode());

        $config = $this->readConfig();
        self::assertCount(2, $config['repositories']);
        self::assertSame('https://github.com/existing/repo.git', $config['repositories'][0]['url']);
        self::assertSame('https://github.com/foo/bar.git', $config['repositories'][1]['url']);
    }

    #[TestDox('Initializes the repositories key when it is missing')]
    public function testAddRepositoryInitializesRepositoriesKey(): void
    {
        $this->writeConfig(['name' => 'test/repo']);
        $tester = $this->createTester();
        $tester->execute(['url' => 'https://github.com/foo/bar.git', 'file' => $this->configPath]);

        self::assertSame(0, $tester->getStatusCode());

        $config = $this->readConfig();
        self::assertCount(1, $config['repositories']);
        self::assertSame('https://github.com/foo/bar.git', $config['repositories'][0]['url']);
    }

    #[TestDox('Replaces a non-array repositories value with a valid array')]
    public function testAddRepositoryInitializesNonArrayRepositories(): void
    {
        $this->writeConfig(['name' => 'test/repo', 'repositories' => 'invalid']);
        $tester = $this->createTester();
        $tester->execute(['url' => 'https://github.com/foo/bar.git', 'file' => $this->configPath]);

        self::assertSame(0, $tester->getStatusCode());

        $config = $this->readConfig();
        self::assertIsArray($config['repositories']);
        self::assertCount(1, $config['repositories']);
        self::assertSame('https://github.com/foo/bar.git', $config['repositories'][0]['url']);
    }

    #[TestDox('isRepositoryValid returns false when the URL causes an exception')]
    public function testIsRepositoryValidReturnsFalseOnException(): void
    {
        $command = new AddCommand();
        $method = new \ReflectionMethod($command, 'isRepositoryValid');

        self::assertFalse($method->invoke($command, 'not-a-valid-url-at-all', 'vcs'));
    }

    #[TestDox('isRepositoryValid returns false when no VCS driver matches')]
    public function testIsRepositoryValidReturnsFalseOnNullDriver(): void
    {
        $command = new AddCommand();
        $method = new \ReflectionMethod($command, 'isRepositoryValid');

        self::assertFalse($method->invoke($command, 'https://example.com/nonexistent-repo.git', 'vcs'));
    }
}
