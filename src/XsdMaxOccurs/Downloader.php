<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\XsdMaxOccurs;

use RuntimeException;
use Throwable;

final class Downloader implements DownloaderInterface
{
    public function get(string $url): string
    {
        try {
            $contents = file_get_contents($url);
        } catch (Throwable $exception) {
            throw new RuntimeException("Unable to get $url contents", 0, $exception);
        }
        if (false === $contents) {
            throw new RuntimeException("Unable to get $url contents");
        }
        if ('' === $contents) {
            throw new RuntimeException("Content from $url is empty");
        }
        return $contents;
    }
}
