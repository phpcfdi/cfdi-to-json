<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\Nodes;

use PhpCfdi\CfdiToJson\UnboundedOccursPaths;

final class Children
{
    /** @var Node[] */
    private array $children = [];

    private readonly KeysCounter $keysCounter;

    public function __construct(
        private readonly UnboundedOccursPaths $unboundedOccursPaths,
    ) {
        $this->keysCounter = new KeysCounter();
    }

    public function append(Node $child): void
    {
        $this->children[] = $child;
        $this->keysCounter->register($child->getKey());
    }

    public function isChildrenMultiple(Node $child): bool
    {
        return $this->keysCounter->hasMany($child->getKey())
            || $this->unboundedOccursPaths->match($child->getPath());
    }

    /**
     * @phpstan-ignore-next-line
     */
    public function toArray(): array
    {
        $children = [];

        foreach ($this->children as $item) {
            if ($this->isChildrenMultiple($item)) {
                $children[$item->getKey()][] = $item->toArray();
            } else {
                if (isset($children[$item->getKey()]) && is_array($children[$item->getKey()])) {
                    $children[$item->getKey()][] = $item->toArray();
                } else {
                    $children[$item->getKey()] = $item->toArray();
                }
            }
        }

        return $children;
    }
}
