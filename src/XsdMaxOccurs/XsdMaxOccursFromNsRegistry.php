<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\XsdMaxOccurs;

use RuntimeException;

final class XsdMaxOccursFromNsRegistry
{
    public const DEFAULT_REGISTRY_URL
        = 'https://raw.githubusercontent.com/phpcfdi/sat-ns-registry/master/complementos_v1.json';

    /** @var string */
    private $registryUrl;

    /** @var FinderInterface */
    private $finder;

    /** @var DownloaderInterface */
    private $downloader;

    public function __construct(
        string $registryUrl = self::DEFAULT_REGISTRY_URL,
        ?DownloaderInterface $downloader = null,
        ?FinderInterface $finder = null
    ) {
        $this->registryUrl = $registryUrl;
        $this->downloader = $downloader ?? new Downloader();
        $this->finder = $finder ?? new Finder();
    }

    public function getRegistryUrl(): string
    {
        return $this->registryUrl;
    }

    public function getFinder(): FinderInterface
    {
        return $this->finder;
    }

    /** @return string[] */
    public function obtainPaths(): array
    {
        $registryContents = $this->downloadUrl($this->getRegistryUrl());
        $entries = json_decode($registryContents, true, JSON_THROW_ON_ERROR);
        if (! is_array($entries)) {
            throw new RuntimeException('Unexpected registry structure, root entry is not an array');
        }

        return $this->obtainPathsFromEntries($entries);
    }

    /**
     * @param mixed[] $entries
     * @return string[]
     */
    private function obtainPathsFromEntries(array $entries): array
    {
        $paths = [];
        foreach ($entries as $index => $entry) {
            $paths[] = $this->obtainPathsFromEntry($index, $entry);
        }
        if ([] === $paths) {
            return [];
        }

        $entries = array_merge(...$paths);
        sort($entries);
        $entries = array_values(array_unique($entries));

        return $entries;
    }

    /**
     * @param int|string $index
     * @param mixed $entry
     * @return string[]
     */
    private function obtainPathsFromEntry($index, $entry): array
    {
        if (! is_array($entry)) {
            throw new RuntimeException("Unexpected registry structure, entry $index is not an array");
        }
        if (! isset($entry['xsd']) || ! is_string($entry['xsd'])) {
            throw new RuntimeException("Unexpected registry structure, entry $index does not contains xsd key");
        }
        $xsdContents = $this->downloadUrl($entry['xsd']);
        return $this->getFinder()->obtainPathsFromXsdContents($xsdContents);
    }

    public function downloadUrl(string $url): string
    {
        return $this->downloader->get($url);
    }
}
