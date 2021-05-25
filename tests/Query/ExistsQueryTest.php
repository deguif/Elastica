<?php

namespace Elastica\Test\Query;

use Elastica\Query\ExistsQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class ExistsQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testToArray(): void
    {
        $field = 'test';
        $query = new ExistsQuery($field);

        $expectedArray = ['exists' => ['field' => $field]];
        $this->assertEquals($expectedArray, $query->toArray());
    }

    /**
     * @group unit
     */
    public function testSetField(): void
    {
        $field = 'test';
        $query = new ExistsQuery($field);

        $this->assertSame($field, $query->getParam('field'));

        $newField = 'hello world';
        $query->setField($newField);

        $this->assertEquals($newField, $query->getParam('field'));
    }
}
