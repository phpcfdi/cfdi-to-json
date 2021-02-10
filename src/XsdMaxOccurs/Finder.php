<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\XsdMaxOccurs;

use DOMDocument;
use DOMElement;
use DOMNodeList;
use DOMXPath;

final class Finder implements FinderInterface
{
    public function obtainPathsFromXsdContents(string $xsdContents): array
    {
        $document = new DOMDocument();
        $document->loadXML($xsdContents);

        return array_merge(
            $this->obtainPathsForXPathQuery($document, '//x:element[@maxOccurs="unbounded"]'),
            $this->obtainPathsForXPathQuery($document, '//x:sequence[@maxOccurs="unbounded"]/x:element'),
            $this->obtainPathsForXPathQuery($document, '//x:choice[@maxOccurs="unbounded"]/x:element'),
        );
    }

    /**
     * @param DOMDocument $document
     * @param string $query
     * @return string[]
     */
    private function obtainPathsForXPathQuery(DOMDocument $document, string $query): array
    {
        $paths = [];
        $xpath = new DOMXPath($document);
        $xpath->registerNamespace('x', 'http://www.w3.org/2001/XMLSchema');
        $nodes = $xpath->query($query) ?: new DOMNodeList();
        foreach ($nodes as $node) {
            if ($node instanceof DOMElement) {
                $paths[] = $this->obtainPathForElement($node);
            }
        }
        return $paths;
    }

    private function obtainPathForElement(DOMElement $xsElement): string
    {
        $pathItems = [];

        while (null !== $xsElement) {
            $pathItems[] = $xsElement->getAttribute('name');
            $xsElement = $this->findParentElement($xsElement);
        }

        return '/' . implode('/', array_reverse($pathItems));
    }

    private function findParentElement(DOMElement $node): ?DOMElement
    {
        for ($node = $node->parentNode; null !== $node; $node = $node->parentNode) {
            if ('element' !== $node->localName || 'http://www.w3.org/2001/XMLSchema' !== $node->namespaceURI) {
                continue;
            }
            return $node;
        }
        return null;
    }
}
