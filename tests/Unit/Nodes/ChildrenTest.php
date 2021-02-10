<?php

declare(strict_types=1);

namespace PhpCfdi\CfdiToJson\Tests\Unit\Nodes;

use PhpCfdi\CfdiToJson\Nodes\Children;
use PhpCfdi\CfdiToJson\Nodes\Node;
use PhpCfdi\CfdiToJson\Tests\TestCase;
use PhpCfdi\CfdiToJson\UnboundedOccursPaths;

final class ChildrenTest extends TestCase
{
    public function testGetChildrenCountByKey(): void
    {
        $unboundedOccursPaths = new UnboundedOccursPaths();
        $children = new Children($unboundedOccursPaths);
        $children->append($nodeAuthor = new Node('author', '/', [], new Children($unboundedOccursPaths)));
        $children->append($nodeChapter = new Node('chapter', '/', [], new Children($unboundedOccursPaths)));
        $children->append(new Node('chapter', '/', [], new Children($unboundedOccursPaths)));

        $this->assertFalse($children->isChildrenMultiple($nodeAuthor));
        $this->assertTrue($children->isChildrenMultiple($nodeChapter));

        $nodeNonExistent = new Node('non-existent', '/', [], new Children($unboundedOccursPaths));
        $this->assertFalse($children->isChildrenMultiple($nodeNonExistent));
    }
}
