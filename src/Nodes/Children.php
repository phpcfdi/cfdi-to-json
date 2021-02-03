<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\Nodes;

use PhpCfdi\CfdiToJson\UnboundedOccursPaths;

final class Children
{
    /** @var Node[] */
    private $children = [];

    /** @var UnboundedOccursPaths */
    private $unboundedOccursPaths;

    /** @var array<string, int> */
    private $childrenCountByKey = [];

    public function __construct(UnboundedOccursPaths $unboundedOccursPaths)
    {
        $this->unboundedOccursPaths = $unboundedOccursPaths;
    }

    public function append(Node $child): void
    {
        $this->children[] = $child;
        $this->childrenCountByKey[$child->getKey()] = $this->getChildrenCountByKey($child->getKey());
    }

    public function isChildrenMultiple(Node $child): bool
    {
        return ($this->getChildrenCountByKey($child->getKey()) > 1)
            || $this->unboundedOccursPaths->match($child->getPath());
    }

    private function getChildrenCountByKey(string $key): int
    {
        return $this->childrenCountByKey[$key] ?? 0;
    }

    /** @return array<string, string|array> */
    public function toArray(): array
    {
        $children = [];

        foreach ($this->children as $item) {
            if ($this->isChildrenMultiple($item)) {
                $children[$item->getKey()][] = $item->toArray();
            } else {
                $children[$item->getKey()] = $item->toArray();
            }
        }

        return $children;
    }
}
