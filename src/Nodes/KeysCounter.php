<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\Nodes;

final class KeysCounter
{
    /** @var array<string, int> */
    private $counts;

    public function register(string $key): void
    {
        $this->counts[$key] = $this->get($key) + 1;
    }

    public function get(string $key): int
    {
        return $this->counts[$key] ?? 0;
    }

    public function hasMany(string $key): bool
    {
        return $this->get($key) > 1;
    }
}
