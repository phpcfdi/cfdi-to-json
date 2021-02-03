<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\Tests\Unit\XsdMaxOccurs;

use PhpCfdi\CfdiToJson\Tests\TestCase;
use PhpCfdi\CfdiToJson\XsdMaxOccurs\DownloaderInterface;
use PhpCfdi\CfdiToJson\XsdMaxOccurs\FinderInterface;
use PhpCfdi\CfdiToJson\XsdMaxOccurs\XsdMaxOccursFromNsRegistry;
use PHPUnit\Framework\MockObject\MockObject;
use RuntimeException;

final class XsdMaxOccursFromNsRegistryTest extends TestCase
{
    public function testCreateUsesDefaultRegistryLocation(): void
    {
        $object = new XsdMaxOccursFromNsRegistry();
        $this->assertSame(XsdMaxOccursFromNsRegistry::DEFAULT_REGISTRY_URL, $object->getRegistryUrl());
    }

    public function testCreateUsesCustomRegistryLocation(): void
    {
        $location = 'http://example.com/custom-location';
        $object = new XsdMaxOccursFromNsRegistry($location);
        $this->assertSame($location, $object->getRegistryUrl());
    }

    public function testObtainPathsUsingFakeRegistry(): void
    {
        /** @var FinderInterface&MockObject $finder */
        $finder = $this->createMock(FinderInterface::class);
        $finder->method('obtainPathsFromXsdContents')->willReturn(
            [
                '/first/foo/bar/baz',
                '/first/foo/bar/xee',
            ],
            [
                '/second/foo/bar/baz',
                '/second/foo/bar/xee',
            ]
        );

        /** @var DownloaderInterface&MockObject $downloader */
        $downloader = $this->createMock(DownloaderInterface::class);
        $downloader->method('get')->willReturn(
            '[{"xsd": "http://fake/first.xsd"}, {"xsd": "http://fake/second.xsd"}]',
            'first',
            'second',
        );

        $location = 'http://fake/registry';
        $object = new XsdMaxOccursFromNsRegistry($location, $downloader, $finder);
        $paths = $object->obtainPaths();
        $expectedPaths = [
            '/first/foo/bar/baz',
            '/first/foo/bar/xee',
            '/second/foo/bar/baz',
            '/second/foo/bar/xee',
        ];
        $this->assertSame($expectedPaths, $paths);
    }

    public function testObtainPathsUsingInvalidRegistryStructure(): void
    {
        /** @var DownloaderInterface&MockObject $downloader */
        $downloader = $this->createMock(DownloaderInterface::class);
        $downloader->method('get')->willReturn('');

        $location = 'http://fake/registry';
        $object = new XsdMaxOccursFromNsRegistry($location, $downloader);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unexpected registry structure, root entry is not an array');
        $object->obtainPaths();
    }

    public function testObtainPathsUsingEmptyRegistryStructure(): void
    {
        /** @var DownloaderInterface&MockObject $downloader */
        $downloader = $this->createMock(DownloaderInterface::class);
        $downloader->method('get')->willReturn('[]');

        $location = 'http://fake/registry';
        $object = new XsdMaxOccursFromNsRegistry($location, $downloader);

        $this->assertSame([], $object->obtainPaths());
    }

    public function testObtainPathsFromEntryWhenEntryIsNotAnArray(): void
    {
        /** @var FinderInterface&MockObject $finder */
        $finder = $this->createMock(FinderInterface::class);

        /** @var DownloaderInterface&MockObject $downloader */
        $downloader = $this->createMock(DownloaderInterface::class);
        $downloader->method('get')->willReturn('[{"xsd": ""}, ""]');

        $location = 'http://fake/registry';
        $object = new XsdMaxOccursFromNsRegistry($location, $downloader, $finder);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unexpected registry structure, entry 1 is not an array');
        $object->obtainPaths();
    }

    public function testObtainPathsFromEntryWhenEntryDoesNotHaveXsdLocation(): void
    {
        /** @var FinderInterface&MockObject $finder */
        $finder = $this->createMock(FinderInterface::class);

        /** @var DownloaderInterface&MockObject $downloader */
        $downloader = $this->createMock(DownloaderInterface::class);
        $downloader->method('get')->willReturn('[{"xsd": ""}, []]');

        $location = 'http://fake/registry';
        $object = new XsdMaxOccursFromNsRegistry($location, $downloader, $finder);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unexpected registry structure, entry 1 does not contains xsd key');
        $object->obtainPaths();
    }
}
