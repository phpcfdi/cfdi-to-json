<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson;

final class UnboundedOccursPaths
{
    /** @var string[] */
    private $paths;

    public function __construct(string ...$paths)
    {
        $this->paths = $paths;
    }

    public function match(string $path): bool
    {
        foreach ($this->paths as $test) {
            if ($this->pathMatches($path, $test)) {
                return true;
            }
        }

        return false;
    }

    public function pathMatches(string $subject, string $path): bool
    {
        // $subject: /foo/bar/xee/wii
        // $path: /xee/wii
        return (substr($subject, -strlen($path)) === $path);
    }
}
