<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson;

use JsonException;
use LogicException;

final class Factory
{
    /** @var UnboundedOccursPaths */
    private $unboundedOccursPaths;

    public function __construct(?UnboundedOccursPaths $unboundedOccursPaths = null)
    {
        $this->unboundedOccursPaths = $unboundedOccursPaths ?? $this->createDefaultUnboundedOccursPaths();
    }

    public function createConverter(): CfdiToDataNode
    {
        $unboundedOccursPaths = $this->getUnboundedOccursPaths();
        return new CfdiToDataNode($unboundedOccursPaths);
    }

    public function getUnboundedOccursPaths(): UnboundedOccursPaths
    {
        return $this->unboundedOccursPaths;
    }

    public function createDefaultUnboundedOccursPaths(): UnboundedOccursPaths
    {
        return $this->createUnboundedOccursPathsUsingJsonFile(__DIR__ . '/UnboundedOccursPaths.json');
    }

    public function createUnboundedOccursPathsUsingJsonFile(string $sourceFile): UnboundedOccursPaths
    {
        $contents = file_get_contents($sourceFile);
        if (false === $contents) {
            throw new LogicException("Unable to open file $sourceFile");
        }

        try {
            $unboundedOccursPaths = $this->createUnboundedOccursPathsUsingJsonSource($contents);
        } catch (JsonException | LogicException $exception) {
            throw new LogicException("The file $sourceFile has invalid contents", 0, $exception);
        }

        return $unboundedOccursPaths;
    }

    /**
     * @param string $contents
     * @return UnboundedOccursPaths
     * @throws JsonException|LogicException
     */
    public function createUnboundedOccursPathsUsingJsonSource(string $contents): UnboundedOccursPaths
    {
        $sourcePaths = json_decode(strval($contents), true, 512, JSON_THROW_ON_ERROR);

        if (! is_array($sourcePaths)) {
            throw new LogicException('JSON does not contains an array of entries');
        }

        foreach ($sourcePaths as $index => $sourcePath) {
            if (! is_string($sourcePath)) {
                throw new LogicException("JSON does not contains a string on index $index");
            }
        }

        return new UnboundedOccursPaths(...$sourcePaths);
    }
}
