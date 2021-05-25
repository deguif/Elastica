<?php

namespace Elastica\Test\Query;

use Elastica\Document;
use Elastica\Query\MatchNoneQuery;
use Elastica\Search;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class MatchNoneQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testToArray(): void
    {
        $query = new MatchNoneQuery();

        $expectedArray = ['match_none' => new \stdClass()];

        $this->assertEquals($expectedArray, $query->toArray());
    }

    /**
     * @group functional
     */
    public function testMatchNone(): void
    {
        $index = $this->_createIndex();
        $client = $index->getClient();

        $doc = new Document(1, ['name' => 'ruflin']);
        $index->addDocument($doc);

        $index->refresh();

        $search = new Search($client);
        $resultSet = $search->search(new MatchNoneQuery());

        $this->assertEquals(0, $resultSet->getTotalHits());
    }
}
