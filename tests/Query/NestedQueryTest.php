<?php

namespace Elastica\Test\Query;

use Elastica\Query\NestedQuery;
use Elastica\Query\QueryStringQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class NestedQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testSetQuery(): void
    {
        $queryString = new QueryStringQuery('test');
        $path = 'test1';

        $nested = (new NestedQuery())
            ->setQuery($queryString)
            ->setPath($path)
        ;

        $expected = [
            'nested' => [
                'query' => $queryString->toArray(),
                'path' => $path,
            ],
        ];

        $this->assertSame($expected, $nested->toArray());
    }
}
