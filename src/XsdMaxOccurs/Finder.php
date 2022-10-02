<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\XsdMaxOccurs;

use DOMAttr;
use DOMDocument;
use DOMElement;
use DOMNodeList;
use DOMXPath;

final class Finder implements FinderInterface
{
    const NS_XMLSCHEMA = 'http://www.w3.org/2001/XMLSchema';

    /** @var string */
    private $targetNamespace = '';

    public function obtainPathsFromXsdContents(string $xsdContents): array
    {
        $document = new DOMDocument();
        $document->loadXML($xsdContents);

        $this->targetNamespace = $this->findTargetNamespace($document);

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
        $xpath->registerNamespace('x', self::NS_XMLSCHEMA);
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

        return sprintf('{%s}/%s', $this->targetNamespace, implode('/', array_reverse($pathItems)));
    }

    private function findParentElement(DOMElement $node): ?DOMElement
    {
        for ($node = $node->parentNode; $node instanceof DOMElement; $node = $node->parentNode) {
            if ('element' !== $node->localName || self::NS_XMLSCHEMA !== $node->namespaceURI) {
                continue;
            }
            return $node;
        }
        return null;
    }

    private function findTargetNamespace(DOMDocument $document): string
    {
        $xpath = new DOMXPath($document);
        $xpath->registerNamespace('x', self::NS_XMLSCHEMA);
        /** @var DOMNodeList<DOMAttr> $targets */
        $targets = $xpath->query('/x:schema/@targetNamespace') ?: new DOMNodeList();
        /** @var DOMAttr|null $firstTarget */
        $firstTarget = $targets->item(0);
        return $firstTarget->value ?? '';
    }
}
