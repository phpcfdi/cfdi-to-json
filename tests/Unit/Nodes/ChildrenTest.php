<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\Tests\Unit\Nodes;

use PhpCfdi\CfdiToJson\Nodes\Children;
use PhpCfdi\CfdiToJson\Nodes\Node;
use PhpCfdi\CfdiToJson\Tests\TestCase;
use PhpCfdi\CfdiToJson\UnboundedOccursPaths;

final class ChildrenTest extends TestCase
{
    public function testIsChildrenMultipleDetectDuplicatedNodeNames(): void
    {
        $unboundedOccursPaths = new UnboundedOccursPaths();
        $children = new Children($unboundedOccursPaths);
        $nodeChapter = new Node('chapter', '/', [], new Children($unboundedOccursPaths));
        $children->append($nodeChapter);
        $children->append($nodeChapter);

        $this->assertTrue($children->isChildrenMultiple($nodeChapter));
    }
}
