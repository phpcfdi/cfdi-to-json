<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\Tests\Unit;

use JsonException;
use LogicException;
use PhpCfdi\CfdiToJson\Factory;
use PhpCfdi\CfdiToJson\Tests\TestCase;
use PhpCfdi\CfdiToJson\UnboundedOccursPaths;

final class FactoryTest extends TestCase
{
    public function testConstructFactoryUsesDefaultUnboundedOccursPaths(): void
    {
        $factory = new Factory();
        $this->assertEquals($factory->createDefaultUnboundedOccursPaths(), $factory->getUnboundedOccursPaths());
    }

    public function testConstructFactoryUsesGivenUnboundedOccursPaths(): void
    {
        $unboundedOccursPaths = new UnboundedOccursPaths();
        $factory = new Factory($unboundedOccursPaths);
        $this->assertEquals($unboundedOccursPaths, $factory->getUnboundedOccursPaths());
        $converter = $factory->createConverter();
        $this->assertSame($unboundedOccursPaths, $converter->getUnboundedOccursPaths());
    }

    public function testCreateUnboundedOccursPathsUsingJsonFileUsingInvalidFileWithErrorReporting(): void
    {
        $factory = new Factory(new UnboundedOccursPaths());
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Unable to open file');
        $factory->createUnboundedOccursPathsUsingJsonFile(__DIR__ . '/not-found');
    }

    public function testCreateUnboundedOccursPathsUsingJsonFileUsingInvalidFileWithoutErrorReporting(): void
    {
        $factory = new Factory(new UnboundedOccursPaths());

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Unable to open file');

        /** @noinspection PhpUsageOfSilenceOperatorInspection */
        @$factory->createUnboundedOccursPathsUsingJsonFile(__DIR__ . '/not-found');
    }

    public function testCreateUnboundedOccursPathsUsingJsonFileUsingInvalidContents(): void
    {
        $factory = new Factory(new UnboundedOccursPaths());
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('has invalid contents');
        $factory->createUnboundedOccursPathsUsingJsonFile(__FILE__);
    }

    public function testCreateUnboundedOccursPathsUsingJsonSourceWithInvalidJson(): void
    {
        $factory = new Factory(new UnboundedOccursPaths());
        $this->expectException(JsonException::class);
        $factory->createUnboundedOccursPathsUsingJsonSource('');
    }

    public function testCreateUnboundedOccursPathsUsingJsonNotArray(): void
    {
        $factory = new Factory(new UnboundedOccursPaths());
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('JSON does not contains an array of entries');
        $factory->createUnboundedOccursPathsUsingJsonSource('""');
    }

    public function testCreateUnboundedOccursPathsUsingJsonNotArrayOfStrings(): void
    {
        $factory = new Factory(new UnboundedOccursPaths());
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('JSON does not contains a string on index 1');
        $factory->createUnboundedOccursPathsUsingJsonSource('["string", 2]');
    }
}
