<?php

declare(strict_types=);

namespace PhpCfdi\CfdiToJson\Tests\Functional;

use PhpCfdi\CfdiToJson\JsonConverter;

class DetallistaTest extends \PhpCfdi\CfdiToJson\Tests\TestCase
{
    public function testComplementoDetallista(): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->assertJsonStringEqualsJsonString(
            $this->fileContents('detallista-example.json'),
            JsonConverter::convertToJson($this->fileContents('detallista-example.xml'))
        );
    }
}
