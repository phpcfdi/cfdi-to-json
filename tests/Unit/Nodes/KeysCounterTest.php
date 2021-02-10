<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\Tests\Unit\Nodes;

use PhpCfdi\CfdiToJson\Nodes\KeysCounter;
use PhpCfdi\CfdiToJson\Tests\TestCase;

final class KeysCounterTest extends TestCase
{
    private function createPopulatedCounter(string ...$keys): KeysCounter
    {
        $counter = new KeysCounter();
        foreach ($keys as $key) {
            $counter->register($key);
        }
        return $counter;
    }

    public function testHasMany(): void
    {
        $counter = $this->createPopulatedCounter('author', 'chapter', 'chapter');

        $this->assertTrue($counter->hasMany('chapter'));
        $this->assertFalse($counter->hasMany('author'));
        $this->assertFalse($counter->hasMany('non-existent'));
    }

    public function testGet(): void
    {
        $counter = $this->createPopulatedCounter('author', 'chapter', 'chapter');

        $this->assertSame(2, $counter->get('chapter'));
        $this->assertSame(1, $counter->get('author'));
        $this->assertSame(0, $counter->get('non-existent'));
    }
}
