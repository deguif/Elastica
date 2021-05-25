<?php

namespace Elastica\Test\Query;

use Elastica\Query\PrefixQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class PrefixQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testToArray(): void
    {
        $query = new PrefixQuery();
        $key = 'name';
        $value = 'ni';
        $boost = 2;
        $query->setPrefix($key, $value, $boost);

        $data = $query->toArray();

        $this->assertIsArray($data['prefix']);
        $this->assertIsArray($data['prefix'][$key]);
        $this->assertEquals($data['prefix'][$key]['value'], $value);
        $this->assertEquals($data['prefix'][$key]['boost'], $boost);
    }
}
