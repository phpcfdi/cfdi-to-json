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
            '{http://tempuri.org/document}/Document/Chapter',
            '{http://tempuri.org/document}/Document/Chapter/Section',
            '{http://tempuri.org/document}/Document/Authors/Author',
            '{http://tempuri.org/document}/Document/Authors/Coauthor', // sequence
            '{http://tempuri.org/document}/Document/Review/Status', // choice
        ];

        $this->assertEquals($expectedPaths, $paths);
    }
}
