<?php

namespace Elastica\Test\Query;

use Elastica\Document;
use Elastica\Query\DisMaxQuery;
use Elastica\Query\IdsQuery;
use Elastica\Query\QueryStringQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class DisMaxQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testToArray(): void
    {
        $query = new DisMaxQuery();

        $idsQuery1 = new IdsQuery();
        $idsQuery1->setIds(1);

        $idsQuery2 = new IdsQuery();
        $idsQuery2->setIds(2);

        $idsQuery3 = new IdsQuery();
        $idsQuery3->setIds(3);

        $boost = 1.2;
        $tieBreaker = 0.7;

        $query->setBoost($boost);
        $query->setTieBreaker($tieBreaker);
        $query->addQuery($idsQuery1);
        $query->addQuery($idsQuery2);
        $query->addQuery($idsQuery3->toArray());

        $expectedArray = [
            'dis_max' => [
                'tie_breaker' => $tieBreaker,
                'boost' => $boost,
                'queries' => [
                    $idsQuery1->toArray(),
                    $idsQuery2->toArray(),
                    $idsQuery3->toArray(),
                ],
            ],
        ];

        $this->assertEquals($expectedArray, $query->toArray());
    }

    /**
     * @group functional
     */
    public function testQuery(): void
    {
        $index = $this->_createIndex();

        $index->addDocuments([
            new Document(1, ['name' => 'Basel-Stadt']),
            new Document(2, ['name' => 'New York']),
            new Document(3, ['name' => 'Baden']),
            new Document(4, ['name' => 'Baden Baden']),
        ]);

        $index->refresh();

        $queryString1 = new QueryStringQuery('Bade*');
        $queryString2 = new QueryStringQuery('Base*');

        $boost = 1.2;
        $tieBreaker = 0.5;

        $query = new DisMaxQuery();
        $query->setBoost($boost);
        $query->setTieBreaker($tieBreaker);
        $query->addQuery($queryString1);
        $query->addQuery($queryString2);
        $resultSet = $index->search($query);

        $this->assertEquals(3, $resultSet->count());
    }

    /**
     * @group functional
     */
    public function testQueryArray(): void
    {
        $index = $this->_createIndex();

        $index->addDocuments([
            new Document(1, ['name' => 'Basel-Stadt']),
            new Document(2, ['name' => 'New York']),
            new Document(3, ['name' => 'Baden']),
            new Document(4, ['name' => 'Baden Baden']),
        ]);

        $index->refresh();

        $queryString1 = ['query_string' => [
            'query' => 'Bade*',
        ],
        ];

        $queryString2 = ['query_string' => [
            'query' => 'Base*',
        ],
        ];

        $boost = 1.2;
        $tieBreaker = 0.5;

        $query = new DisMaxQuery();
        $query->setBoost($boost);
        $query->setTieBreaker($tieBreaker);
        $query->addQuery($queryString1);
        $query->addQuery($queryString2);
        $resultSet = $index->search($query);

        $this->assertEquals(3, $resultSet->count());
    }
}
