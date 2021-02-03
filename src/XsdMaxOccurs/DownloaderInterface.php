<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\XsdMaxOccurs;

interface DownloaderInterface
{
    public function get(string $url): string;
}
