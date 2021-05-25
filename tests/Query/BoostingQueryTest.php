<?php

namespace Elastica\Test\Query;

use Elastica\Query\BoostingQuery;
use Elastica\Query\TermQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class BoostingQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testToArray(): void
    {
        $keyword = 'vital';
        $negativeKeyword = 'Mercury';

        $query = new BoostingQuery();
        $positiveQuery = new TermQuery(['name' => $keyword]);
        $negativeQuery = new TermQuery(['name' => $negativeKeyword]);
        $query->setPositiveQuery($positiveQuery);
        $query->setNegativeQuery($negativeQuery);
        $query->setNegativeBoost(0.3);

        $expected = [
            'boosting' => [
                'positive' => $positiveQuery->toArray(),
                'negative' => $negativeQuery->toArray(),
                'negative_boost' => 0.3,
            ],
        ];
        $this->assertEquals($expected, $query->toArray());
    }

    /**
     * @group unit
     */
    public function testNegativeBoost(): void
    {
        $keyword = 'vital';
        $negativeKeyword = 'mercury';

        $query = new BoostingQuery();
        $positiveQuery = new TermQuery();
        $positiveQuery->setTerm('name', $keyword, 5.0);
        $negativeQuery = new TermQuery();
        $negativeQuery->setTerm('name', $negativeKeyword, 8.0);
        $query->setPositiveQuery($positiveQuery);
        $query->setNegativeQuery($negativeQuery);
        $query->setNegativeBoost(23.0);
        $query->setParam('boost', 42.0);

        $queryToCheck = $query->toArray();
        $this->assertEquals(42.0, $queryToCheck['boosting']['boost']);
        $this->assertEquals(5.0, $queryToCheck['boosting']['positive']['term']['name']['boost']);
        $this->assertEquals(8.0, $queryToCheck['boosting']['negative']['term']['name']['boost']);
        $this->assertEquals(23.0, $queryToCheck['boosting']['negative_boost']);
    }
}
