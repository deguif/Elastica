<?php

namespace Elastica\Test\Query;

use Elastica\Query\RegexpQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class RegexpQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testToArray(): void
    {
        $field = 'name';
        $value = 'ruf';
        $boost = 2;

        $query = new RegexpQuery($field, $value, $boost);

        $expectedArray = [
            'regexp' => [
                $field => [
                    'value' => $value,
                    'boost' => $boost,
                ],
            ],
        ];

        $this->assertequals($expectedArray, $query->toArray());
    }
}
