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

namespace Composer\Satis\Plugin;

use Composer\Composer;
use Composer\IO\IOInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[TestDox('SatisPlugin')]
#[CoversClass(SatisPlugin::class)]
class SatisPluginTest extends TestCase
{
    private SatisPlugin $plugin;

    protected function setUp(): void
    {
        $this->plugin = new SatisPlugin();
    }

    #[TestDox('Can be instantiated')]
    public function testCanBeInstantiated(): void
    {
        self::assertInstanceOf(SatisPlugin::class, $this->plugin);
        self::assertInstanceOf(\Composer\Plugin\PluginInterface::class, $this->plugin);
        self::assertInstanceOf(\Composer\Plugin\Capable::class, $this->plugin);
    }

    #[TestDox('Returns the expected capabilities')]
    public function testGetCapabilities(): void
    {
        $capabilities = $this->plugin->getCapabilities();
        self::assertCount(1, $capabilities);
        self::assertSame(
            'Composer\Plugin\Capability\CommandProvider',
            key($capabilities)
        );
        self::assertSame(CommandProvider::class, current($capabilities));
    }

    #[TestDox('Subscribes to no events')]
    public function testGetSubscribedEvents(): void
    {
        $events = SatisPlugin::getSubscribedEvents();

        self::assertSame([], $events);
    }

    #[TestDox('Activates the plugin with Composer and IO')]
    public function testActivate(): void
    {
        $composer = $this->createMock(Composer::class);
        $io = $this->createMock(IOInterface::class);

        $reflection = new \ReflectionClass($this->plugin);
        $composerProperty = $reflection->getProperty('composer');
        $ioProperty = $reflection->getProperty('io');

        self::assertFalse($composerProperty->isInitialized($this->plugin));
        self::assertFalse($ioProperty->isInitialized($this->plugin));

        $this->plugin->activate($composer, $io);

        self::assertTrue($composerProperty->isInitialized($this->plugin));
        self::assertTrue($ioProperty->isInitialized($this->plugin));
        self::assertSame($composer, $composerProperty->getValue($this->plugin));
        self::assertSame($io, $ioProperty->getValue($this->plugin));
    }

    #[TestDox('Deactivation does nothing')]
    public function testDeactivate(): void
    {
        $composer = $this->createMock(Composer::class);
        $io = $this->createMock(IOInterface::class);

        // Activate first
        $reflection = new \ReflectionClass($this->plugin);
        $composerProperty = $reflection->getProperty('composer');
        $ioProperty = $reflection->getProperty('io');

        $composerProperty->setValue($this->plugin, $composer);
        $ioProperty->setValue($this->plugin, $io);

        // Deactivate (should not throw)
        $this->plugin->deactivate($composer, $io);

        // Verify properties remain unchanged
        self::assertSame($composer, $composerProperty->getValue($this->plugin));
        self::assertSame($io, $ioProperty->getValue($this->plugin));
    }

    #[TestDox('Uninstall does nothing')]
    public function testUninstall(): void
    {
        $composer = $this->createMock(Composer::class);
        $io = $this->createMock(IOInterface::class);

        // Activate first
        $reflection = new \ReflectionClass($this->plugin);
        $composerProperty = $reflection->getProperty('composer');
        $ioProperty = $reflection->getProperty('io');

        $composerProperty->setValue($this->plugin, $composer);
        $ioProperty->setValue($this->plugin, $io);

        // Uninstall (should not throw)
        $this->plugin->uninstall($composer, $io);

        // Verify properties remain unchanged
        self::assertSame($composer, $composerProperty->getValue($this->plugin));
        self::assertSame($io, $ioProperty->getValue($this->plugin));
    }
}
