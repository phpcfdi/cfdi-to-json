<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson;

use JsonException;

final class JsonConverter
{
    /**
     * Helper function to convert a Cfdi XML contents to JSON string
     *
     * @param string $cfdi XML cfdi contents
     * @param int $jsonOptions defaults to JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
     * @return string
     * @throws JsonException
     */
    public static function convertToJson(
        string $cfdi,
        int $jsonOptions = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
    ): string {
        // Cast to string because phpstan does not recognize that it cannot return FALSE because JSON_THROW_ON_ERROR
        return (string) json_encode(self::convertToArray($cfdi), $jsonOptions | JSON_THROW_ON_ERROR);
    }

    /**
     * Helper function to convert a Cfdi XML contents to JSON string
     *
     * @param string $cfdi
     * @return array
     * @phpstan-ignore-next-line
     */
    public static function convertToArray(string $cfdi): array
    {
        $factory = new Factory();
        $converter = $factory->createConverter();
        $dataNode = $converter->convertXmlContent($cfdi);
        return $dataNode->toArray();
    }
}
