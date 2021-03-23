<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\XsdMaxOccurs;

use RuntimeException;

final class Downloader implements DownloaderInterface
{
    public function get(string $url): string
    {
        /** @noinspection PhpUsageOfSilenceOperatorInspection */
        $contents = @file_get_contents($url);
        if (false === $contents) {
            throw new RuntimeException("Unable to get $url contents");
        }
        if ('' === $contents) {
            throw new RuntimeException("Content from $url is empty");
        }
        return $contents;
    }
}
