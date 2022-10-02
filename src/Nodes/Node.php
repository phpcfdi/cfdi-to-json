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

    /** @var string */
    private $value;

    /**
     * @param string $key
     * @param string $path
     * @param array<string, string> $attributes
     * @param Children $children
     * @param string $value
     */
    public function __construct(string $key, string $path, array $attributes, Children $children, string $value = '')
    {
        $this->key = $key;
        $this->path = $path;
        $this->attributes = $attributes;
        $this->children = $children;
        $this->value = $value;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return array<string, string|array>
     * @phpstan-ignore-next-line
     */
    public function toArray(): array
    {
        $textArray = ('' !== $this->getValue()) ? ['' => $this->getValue()] : [];
        return $textArray + $this->attributes + $this->children->toArray();
    }
}
