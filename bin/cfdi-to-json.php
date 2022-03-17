<?php

declare(strict_types=1);

use PhpCfdi\CfdiToJson\Factory;

require __DIR__ . '/../vendor/autoload.php';

exit(call_user_func(function (string $command, string ...$arguments): int {
    $filename = $arguments[0] ?? '';
    $contents = file_get_contents($filename) ?: '';
    $document = new DOMDocument();
    /** @noinspection PhpUsageOfSilenceOperatorInspection */
    @$document->loadXML($contents);

    $factory = new Factory();
    $converter = $factory->createConverter();
    $node = $converter->convertXmlDocument($document);

    echo json_encode($node->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return 0;
}, ...$argv));
