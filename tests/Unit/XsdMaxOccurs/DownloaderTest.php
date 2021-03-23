<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\Tests\Unit\XsdMaxOccurs;

use PhpCfdi\CfdiToJson\Tests\TestCase;
use PhpCfdi\CfdiToJson\XsdMaxOccurs\Downloader;
use RuntimeException;

final class DownloaderTest extends TestCase
{
    public function testDownloaderThrowsExceptionWhenCannotGetContents(): void
    {
        $url = __DIR__ . '/file-not-found';
        $downloader = new Downloader();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Unable to get $url contents");
        $downloader->get($url);
    }

    public function testDownloaderThrowsExceptionWhenCannotGetContentsWithoutErrorReporting(): void
    {
        $url = __DIR__ . '/file-not-found';
        $downloader = new Downloader();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Unable to get $url contents");

        /** @noinspection PhpUsageOfSilenceOperatorInspection */
        @$downloader->get($url);
    }

    public function testDownloaderThrowsExceptionWhenContentIsEmpty(): void
    {
        $url = $this->filePath('empty.txt');
        $downloader = new Downloader();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Content from $url is empty");
        $downloader->get($url);
    }

    public function testDownloaderWithExpectedContent(): void
    {
        $url = __FILE__;
        $downloader = new Downloader();

        $this->assertStringEqualsFile($url, $downloader->get($url));
    }
}
