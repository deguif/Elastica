<?php

namespace Elastica\Test\Query;

use Elastica\Document;
use Elastica\Query\SpanFirstQuery;
use Elastica\Query\SpanTermQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class SpanFirstQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testToArray(): void
    {
        $query = new SpanFirstQuery();
        $query->setMatch(new SpanTermQuery(['user' => 'kimchy']));
        $query->setEnd(3);

        $data = $query->toArray();

        $this->assertEquals([
            'span_first' => [
                'match' => [
                    'span_term' => ['user' => 'kimchy'],
                ],
                'end' => 3,
            ],
        ], $data);
    }

    /**
     * @group functional
     */
    public function testSpanNearTerm(): void
    {
        $field = 'lorem';
        $value = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse odio lacus, aliquam nec nulla quis, aliquam eleifend eros.';

        $index = $this->_createIndex();

        $docHitData = [$field => $value];
        $doc = new Document(1, $docHitData);
        $index->addDocument($doc);
        $index->refresh();

        $spanTerm = new SpanTermQuery([$field => ['value' => 'consectetur']]);

        // consectetur, end 4 won't match
        $spanNearQuery = new SpanFirstQuery($spanTerm, 4);
        $resultSet = $index->search($spanNearQuery);
        $this->assertEquals(0, $resultSet->count());

        $spanTerm = new SpanTermQuery([$field => ['value' => 'lorem']]);

        // lorem, end 3 matches
        $spanNearQuery = new SpanFirstQuery($spanTerm, 3);
        $resultSet = $index->search($spanNearQuery);
        $this->assertEquals(1, $resultSet->count());
    }
}
