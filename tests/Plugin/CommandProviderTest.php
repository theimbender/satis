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

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[TestDox('CommandProvider')]
#[CoversClass(CommandProvider::class)]
class CommandProviderTest extends TestCase
{
    #[TestDox('Can instantiate the command provider')]
    public function testCanInstantiate(): void
    {
        $provider = new CommandProvider();
        self::assertInstanceOf(CommandProvider::class, $provider);
    }

    #[TestDox('Implements the CommandProviderCapability interface')]
    public function testImplementsCommandProviderCapability(): void
    {
        $provider = new CommandProvider();
        self::assertInstanceOf(\Composer\Plugin\Capability\CommandProvider::class, $provider);
    }

    #[TestDox('Returns the expected number of commands')]
    public function testReturnsCorrectCommands(): void
    {
        $provider = new CommandProvider();
        $commands = $provider->getCommands();

        self::assertCount(4, $commands);

        // Verify each command exists and has expected name
        self::assertEquals('satis:add', $commands[0]->getName());
        self::assertEquals('satis:build', $commands[1]->getName());
        self::assertEquals('satis:init', $commands[2]->getName());
        self::assertEquals('satis:purge', $commands[3]->getName());
    }

    #[TestDox('Returns commands that are instances of expected classes')]
    public function testCommandsAreInstancesOfExpectedClasses(): void
    {
        $provider = new CommandProvider();
        $commands = $provider->getCommands();

        self::assertInstanceOf(\Composer\Satis\Console\Command\AddCommand::class, $commands[0]);
        self::assertInstanceOf(\Composer\Satis\Console\Command\BuildCommand::class, $commands[1]);
        self::assertInstanceOf(\Composer\Satis\Console\Command\InitCommand::class, $commands[2]);
        self::assertInstanceOf(\Composer\Satis\Console\Command\PurgeCommand::class, $commands[3]);
    }

    #[TestDox('Command names match plugin registration')]
    public function testCommandNamesMatchPluginRegistration(): void
    {
        $provider = new CommandProvider();
        $commands = $provider->getCommands();

        // Verify against known command names
        $expectedNames = ['satis:add', 'satis:build', 'satis:init', 'satis:purge'];
        $actualNames = array_map(fn ($c) => $c->getName(), $commands);

        self::assertEquals($expectedNames, $actualNames);
    }
}
