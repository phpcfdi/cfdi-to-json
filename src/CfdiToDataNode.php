<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson;

use DOMAttr;
use DOMDocument;
use DOMElement;
use DOMNamedNodeMap;
use DOMText;
use InvalidArgumentException;

final class CfdiToDataNode
{
    /** @var UnboundedOccursPaths */
    private $unboundedOccursPaths;

    public function __construct(UnboundedOccursPaths $unboundedOccursPaths)
    {
        $this->unboundedOccursPaths = $unboundedOccursPaths;
    }

    public function getUnboundedOccursPaths(): UnboundedOccursPaths
    {
        return $this->unboundedOccursPaths;
    }

    public function convertXmlContent(string $xmlContents): Nodes\Node
    {
        $document = new DOMDocument();
        $document->loadXML($xmlContents);
        return $this->convertXmlDocument($document);
    }

    public function convertXmlDocument(DOMDocument $document): Nodes\Node
    {
        if (null === $document->documentElement) {
            throw new InvalidArgumentException('The DOMDocument does not have a root element');
        }
        return $this->convertElementoToDataNode($document->documentElement);
    }

    private function convertElementoToDataNode(DOMElement $element): Nodes\Node
    {
        $path = $this->buildPathForElement($element);
        $value = $this->extractValue($element);

        // children to internal struct
        $convertionChildren = new Nodes\Children($this->unboundedOccursPaths);
        foreach ($element->childNodes as $childElement) {
            if ($childElement instanceof DOMElement) {
                $convertionChildren->append(
                    $this->convertElementoToDataNode($childElement),
                );
            }
        }

        return new Nodes\Node(
            strval($element->localName),
            $path,
            $this->obtainAttributes($element),
            $convertionChildren,
            $value
        );
    }

    /**
     * @param DOMElement $element
     * @return array<string, string>
     */
    private function obtainAttributes(DOMElement $element): array
    {
        /**
         * phpstan does not recognize that DOMElement::attributes cannot be null
         * @phpstan-var DOMNamedNodeMap<DOMAttr> $elementAttributes
         */
        $elementAttributes = $element->attributes;

        $attributes = [];
        foreach ($elementAttributes as $attribute) {
            $attributes[$attribute->nodeName] = $attribute->value;
        }
        return $attributes;
    }

    private function buildPathForElement(DOMElement $element): string
    {
        $namespace = $element->namespaceURI ?: '';
        $parentsStack = [];

        for ($current = $element; null !== $current; $current = $current->parentNode) {
            if ($namespace !== $current->namespaceURI) {
                break;
            }

            $parentsStack[] = $current->localName;
        }

        return sprintf('{%s}/%s', $namespace, implode('/', array_reverse($parentsStack)));
    }

    private function extractValue(DOMElement $element): string
    {
        $values = [];
        foreach ($element->childNodes as $childElement) {
            if (! $childElement instanceof DOMText) {
                continue;
            }
            $values[] = $childElement->wholeText;
        }
        return (string) preg_replace(['/\s+/', '/^ +/', '/ +$/'], [' ', '', ''], implode('', $values));
    }
}
