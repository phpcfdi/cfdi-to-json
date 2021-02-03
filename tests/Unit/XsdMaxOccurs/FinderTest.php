<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\Tests\Unit\XsdMaxOccurs;

use PhpCfdi\CfdiToJson\Tests\TestCase;
use PhpCfdi\CfdiToJson\XsdMaxOccurs\Finder;

final class FinderTest extends TestCase
{
    public function testUsingKnownSchemaReturnsExpectedPaths(): void
    {
        $xsdContents = $this->fileContents('sample-schema.xsd');
        $finder = new Finder();
        $paths = $finder->obtainPathsFromXsdContents($xsdContents);

        $expectedPaths = [
            '/Document/Chapter',
            '/Document/Chapter/Section',
            '/Document/Authors/Author',
            '/Document/Authors/Coauthor', // sequence
            '/Document/Review/Status', // choice
        ];

        $this->assertEquals($expectedPaths, $paths);
    }
}
