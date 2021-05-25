<?php

namespace Elastica\Test\Query;

use Elastica\Query\ConstantScoreQuery;
use Elastica\Query\IdsQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class ConstantScoreTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testToArray(): void
    {
        $query = new ConstantScoreQuery();

        $boost = 1.2;
        $filter = new IdsQuery();
        $filter->setIds([1]);
        $query->setFilter($filter);
        $query->setBoost($boost);

        $expectedArray = [
            'constant_score' => [
                'filter' => $filter->toArray(),
                'boost' => $boost,
            ],
        ];

        $this->assertEquals($expectedArray, $query->toArray());
    }

    /**
     * @group unit
     */
    public function testConstruct(): void
    {
        $filter = new IdsQuery();
        $filter->setIds([1]);

        $query = new ConstantScoreQuery($filter);

        $expectedArray = [
            'constant_score' => [
                'filter' => $filter->toArray(),
            ],
        ];

        $this->assertEquals($expectedArray, $query->toArray());
    }

    /**
     * @group unit
     */
    public function testConstructEmpty(): void
    {
        $query = new ConstantScoreQuery();
        $expectedArray = ['constant_score' => []];

        $this->assertEquals($expectedArray, $query->toArray());
    }
}
