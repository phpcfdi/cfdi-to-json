<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\Tests\Functional;

use PhpCfdi\CfdiToJson\JsonConverter;
use PhpCfdi\CfdiToJson\Tests\TestCase;

final class ConverterTest extends TestCase
{
    /**
     * @var array
     * @phpstan-ignore-next-line
     */
    private $data;

    protected function setUp(): void
    {
        parent::setUp();
        $xmlContents = $this->fileContents('cfdi-example.xml');

        $this->data = JsonConverter::convertToArray($xmlContents);
    }

    public function testConvertExportAttributesFromRootNode(): void
    {
        $this->assertSame('3.3', $this->data['Version'] ?? 'non-existent');
        $this->assertSame('1709.12', $this->data['SubTotal'] ?? 'non-existent');
        $this->assertArrayHasKey('xsi:schemaLocation', $this->data);
    }

    public function testConvertExportChildrenNodesFromRootNode(): void
    {
        $this->assertArrayHasKey('Emisor', $this->data);
    }

    public function testConverterExportDoubleNodesAsArray(): void
    {
        $conceptos = $this->data['Conceptos']['Concepto'] ?? [];
        $this->assertCount(2, $conceptos);

        $firstConcepto = $conceptos[0] ?? [];
        $this->assertSame('Paquete', $firstConcepto['Descripcion'] ?? '');

        $secondConcepto = $conceptos[1] ?? [];
        $this->assertSame('Restaurante', $secondConcepto['Descripcion'] ?? '');
    }

    public function testConverterExportsNodesAsArrayWhenTheyAreKnownFromComprobante(): void
    {
        $this->assertArrayHasKey(0, $this->data['Impuestos']['Traslados']['Traslado']);
    }

    public function testConverterExportsNodesAsArrayWhenTheyAreKnownFromComplemento(): void
    {
        $this->assertArrayHasKey(0, $this->data['Complemento'][0]['ImpuestosLocales']['TrasladosLocales']);
    }

    public function testConverterExportNodeValue(): void
    {
        $data = JsonConverter::convertToArray($this->fileContents('detallista-example.xml'));
        // must replace white-spaces
        $this->assertSame(
            'Un mil ciento sesenta pesos 00/100 m.n.',
            // empty key is the XML Node value
            $data['Complemento'][0]['detallista']['specialInstruction']['text']['']
        );
    }

    public function testJsonConverter(): void
    {
        $xmlContents = $this->fileContents('cfdi-example.xml');
        $jsonFile = $this->filePath('cfdi-example.json');
        /** @noinspection PhpUnhandledExceptionInspection */
        $json = JsonConverter::convertToJson($xmlContents);
        $this->assertJsonStringEqualsJsonFile($jsonFile, $json);
        $this->assertStringEqualsFile($jsonFile, $json, 'Check that the default format is preserved');
    }
}
