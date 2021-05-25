<?php

namespace Elastica\Test\Query;

use Elastica\Document;
use Elastica\Query\SpanNearQuery;
use Elastica\Query\SpanTermQuery;
use Elastica\Query\SpanWithinQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class SpanWithinQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testToArray(): void
    {
        $field = 'name';
        $spanTermQuery1 = new SpanTermQuery([$field => 'nicolas']);
        $spanTermQuery2 = new SpanTermQuery([$field => ['value' => 'alekitto', 'boost' => 1.5]]);
        $spanTermQuery3 = new SpanTermQuery([$field => 'foobar']);
        $spanNearQuery = new SpanNearQuery([$spanTermQuery1, $spanTermQuery2], 5);

        $spanContainingQuery = new SpanWithinQuery($spanTermQuery3, $spanNearQuery);

        $expected = [
            'span_within' => [
                'big' => [
                    'span_near' => [
                        'clauses' => [
                            [
                                'span_term' => [
                                    'name' => 'nicolas',
                                ],
                            ],
                            [
                                'span_term' => [
                                    'name' => [
                                        'value' => 'alekitto',
                                        'boost' => 1.5,
                                    ],
                                ],
                            ],
                        ],
                        'slop' => 5,
                        'in_order' => false,
                    ],
                ],
                'little' => [
                    'span_term' => [
                        'name' => 'foobar',
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $spanContainingQuery->toArray());
    }

    /**
     * @group functional
     */
    public function testSpanWithin(): void
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
        $spanNearQuery = new SpanNearQuery([$spanTermQuery1, $spanTermQuery2], 5);

        $spanContainingQuery = new SpanWithinQuery(new SpanTermQuery([$field => 'amet']), $spanNearQuery);
        $resultSet = $index->search($spanContainingQuery);
        $this->assertEquals(1, $resultSet->count());

        $spanContainingQuery = new SpanWithinQuery(new SpanTermQuery([$field => 'not-matching']), $spanNearQuery);
        $resultSet = $index->search($spanContainingQuery);
        $this->assertEquals(0, $resultSet->count());
    }
}
