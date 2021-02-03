<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\Tests\Unit;

use DOMDocument;
use InvalidArgumentException;
use PhpCfdi\CfdiToJson\CfdiToDataNode;
use PhpCfdi\CfdiToJson\Tests\TestCase;
use PhpCfdi\CfdiToJson\UnboundedOccursPaths;

class CfdiToDataNodeTest extends TestCase
{
    public function testConvertXmlDocumentWithInvalidDomDocumentThrowsException(): void
    {
        $document = new DOMDocument();
        $converter = new CfdiToDataNode(new UnboundedOccursPaths());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The DOMDocument does not have a root element');
        $converter->convertXmlDocument($document);
    }
}
