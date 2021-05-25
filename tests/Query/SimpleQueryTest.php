<?php

namespace Elastica\Test\Query;

use Elastica\Query\SimpleQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class SimpleQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testToArray(): void
    {
        $testQuery = ['hello' => ['world'], 'name' => 'ruflin'];
        $query = new SimpleQuery($testQuery);

        $this->assertEquals($testQuery, $query->toArray());
    }
}
