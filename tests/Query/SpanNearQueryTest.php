<?php

namespace Elastica\Test\Query;

use Elastica\Document;
use Elastica\Exception\InvalidException;
use Elastica\Query\SpanNearQuery;
use Elastica\Query\SpanTermQuery;
use Elastica\Query\TermQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class SpanNearQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testConstructWrongTypeInvalid(): void
    {
        $this->expectException(InvalidException::class);

        $term1 = new TermQuery(['name' => 'marek']);
        $term2 = new TermQuery(['name' => 'nicolas']);

        new SpanNearQuery([$term1, $term2]);
    }

    /**
     * @group unit
     */
    public function testConstructValid(): void
    {
        $field = 'name';
        $spanTermQuery1 = new SpanTermQuery([$field => ['value' => 'marek', 'boost' => 1.5]]);
        $spanTermQuery2 = new SpanTermQuery([$field => 'nicolas']);

        $spanNearQuery = new SpanNearQuery([$spanTermQuery1, $spanTermQuery2], 5, true);

        $expected = [
            'span_near' => [
                'clauses' => [
                    [
                        'span_term' => [
                            'name' => [
                                'value' => 'marek',
                                'boost' => 1.5,
                            ],
                        ],
                    ],
                    [
                        'span_term' => [
                            'name' => 'nicolas',
                        ],
                    ],
                ],
                'slop' => 5,
                'in_order' => true,
            ],
        ];

        $this->assertEquals($expected, $spanNearQuery->toArray());
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

        $spanTermQuery1 = new SpanTermQuery([$field => 'adipiscing']);
        $spanTermQuery2 = new SpanTermQuery([$field => 'lorem']);

        //slop range 4 won't match
        $spanNearQuery = new SpanNearQuery([$spanTermQuery1, $spanTermQuery2], 4);
        $resultSet = $index->search($spanNearQuery);
        $this->assertEquals(0, $resultSet->count());

        //slop range 4 will match
        $spanNearQuery->setSlop(5);
        $resultSet = $index->search($spanNearQuery);
        $this->assertEquals(1, $resultSet->count());

        //in_order set to true won't match
        $spanNearQuery->setInOrder(true);
        $resultSet = $index->search($spanNearQuery);
        $this->assertEquals(0, $resultSet->count());

        $spanNearQuery->addClause(new SpanTermQuery([$field => 'consectetur']));
        $spanNearQuery->setInOrder(false);
        $resultSet = $index->search($spanNearQuery);
        $this->assertEquals(1, $resultSet->count());
    }
}
