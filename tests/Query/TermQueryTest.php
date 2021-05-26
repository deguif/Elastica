<?php

namespace Elastica\Test\Query;

use Elastica\Query\TermQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class TermQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testToArray(): void
    {
        $query = new TermQuery();
        $key = 'name';
        $value = 'nicolas';
        $boost = 2;
        $query->setTerm($key, $value, $boost);

        $data = $query->toArray();

        $this->assertIsArray($data['term']);
        $this->assertIsArray($data['term'][$key]);
        $this->assertEquals($data['term'][$key]['value'], $value);
        $this->assertEquals($data['term'][$key]['boost'], $boost);
    }

    /**
     * @group unit
     */
    public function testDiacriticsValueToArray(): void
    {
        $query = new TermQuery();
        $key = 'name';
        $value = 'diprè';
        $boost = 2;
        $query->setTerm($key, $value, $boost);

        $data = $query->toArray();

        $this->assertIsArray($data['term']);
        $this->assertIsArray($data['term'][$key]);
        $this->assertEquals($data['term'][$key]['value'], $value);
        $this->assertEquals($data['term'][$key]['boost'], $boost);
    }
}
