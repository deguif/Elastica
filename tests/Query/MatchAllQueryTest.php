<?php

namespace Elastica\Test\Query;

use Elastica\Document;
use Elastica\Query\MatchAllQuery;
use Elastica\Search;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class MatchAllQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testToArray(): void
    {
        $query = new MatchAllQuery();

        $expectedArray = ['match_all' => new \stdClass()];

        $this->assertEquals($expectedArray, $query->toArray());
    }

    /**
     * @group functional
     */
    public function testMatchAllIndicesTypes(): void
    {
        $index1 = $this->_createIndex();

        $client = $index1->getClient();

        $search1 = new Search($client);
        $resultSet1 = $search1->search(new MatchAllQuery());

        $doc1 = new Document(1, ['name' => 'kimchy']);
        $doc2 = new Document(2, ['name' => 'ruflin']);
        $index1->addDocuments([$doc1, $doc2]);

        $index1->refresh();

        $search2 = new Search($client);
        $resultSet2 = $search2->search(new MatchAllQuery());

        $this->assertEquals($resultSet1->getTotalHits() + 2, $resultSet2->getTotalHits());
    }
}
