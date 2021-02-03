<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\Nodes;

final class Node
{
    /** @var string */
    private $key;

    /** @var string */
    private $path;

    /** @var Children */
    private $children;

    /** @var array<string, string> */
    private $attributes;

    /**
     * @param string $key
     * @param string $path
     * @param array<string, string> $attributes
     * @param Children $children
     */
    public function __construct(string $key, string $path, array $attributes, Children $children)
    {
        $this->key = $key;
        $this->path = $path;
        $this->attributes = $attributes;
        $this->children = $children;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /** @return array<string, string|array> */
    public function toArray(): array
    {
        return $this->attributes + $this->children->toArray();
    }
}
