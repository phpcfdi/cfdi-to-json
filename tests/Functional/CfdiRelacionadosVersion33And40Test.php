<?php

/**
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\Tests\Functional;

use PhpCfdi\CfdiToJson\JsonConverter;
use PhpCfdi\CfdiToJson\Tests\TestCase;

final class CfdiRelacionadosVersion33And40Test extends TestCase
{
    public function testCfdiRelacionadosVersion33(): void
    {
        $cfdi33 = <<< XML
            <cfdi:Comprobante xmlns:cfdi="http://www.sat.gob.mx/cfd/3">
                <cfdi:CfdiRelacionados TipoRelacion="07">
                    <cfdi:CfdiRelacionado UUID="02b85c96-504a-4203-ac90-590cd991cf40"/>
                </cfdi:CfdiRelacionados>
            </cfdi:Comprobante>
            XML;

        $expectedJson = json_encode([
            'CfdiRelacionados' => [  // CfdiRelacionados must be a hash table (is not multiple)
                'TipoRelacion' => '07',
                'CfdiRelacionado' => [ // CfdiRelacionados must be an array (is multiple)
                    ['UUID' => '02b85c96-504a-4203-ac90-590cd991cf40'],
                ],
            ],
        ], JSON_THROW_ON_ERROR);

        $this->assertJsonStringEqualsJsonString(
            $expectedJson,
            JsonConverter::convertToJson($cfdi33)
        );
    }

    public function testCfdiRelacionadosVersion40(): void
    {
        $cfdi33 = <<< XML
            <cfdi:Comprobante xmlns:cfdi="http://www.sat.gob.mx/cfd/4">
                <cfdi:CfdiRelacionados TipoRelacion="07">
                    <cfdi:CfdiRelacionado UUID="02b85c96-504a-4203-ac90-590cd991cf40"/>
                </cfdi:CfdiRelacionados>
            </cfdi:Comprobante>
            XML;

        $expectedJson = json_encode([
            'CfdiRelacionados' => [ // CfdiRelacionados must be an array (is multiple)
                [
                    'TipoRelacion' => '07',
                    'CfdiRelacionado' => [ // CfdiRelacionado must be an array (is multiple)
                        [
                            'UUID' => '02b85c96-504a-4203-ac90-590cd991cf40',
                        ],
                    ],
                ],
            ],
        ], JSON_THROW_ON_ERROR);

        $this->assertJsonStringEqualsJsonString(
            $expectedJson,
            JsonConverter::convertToJson($cfdi33)
        );
    }
}
