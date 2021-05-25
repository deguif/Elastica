<?php

namespace Elastica\Test\Query;

use Elastica\Document;
use Elastica\Query\SpanNearQuery;
use Elastica\Query\SpanNotQuery;
use Elastica\Query\SpanTermQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class SpanNotQueryTest extends BaseTest
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
        $spanNearQuery = new SpanNearQuery([$spanTermQuery1, $spanTermQuery2], 0, true);

        $spanContainingQuery = new SpanNotQuery($spanTermQuery3, $spanNearQuery);

        $expected = [
            'span_not' => [
                'include' => [
                    'span_term' => [
                        'name' => 'foobar',
                    ],
                ],
                'exclude' => [
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
                        'slop' => 0,
                        'in_order' => true,
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $spanContainingQuery->toArray());
    }

    /**
     * @group functional
     */
    public function testSpanNot(): void
    {
        $field = 'lorem';
        $value = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse odio lacus, aliquam nec nulla quis, aliquam eleifend eros.';

        $index = $this->_createIndex();

        $docHitData = [$field => $value];
        $doc = new Document(1, $docHitData);
        $index->addDocument($doc);
        $index->refresh();

        $spanTermQuery = new SpanTermQuery([$field => 'amet']);
        $spanTermQuery1 = new SpanTermQuery([$field => 'adipiscing']);
        $spanTermQuery2 = new SpanTermQuery([$field => 'lorem']);
        $spanNearQuery = new SpanNearQuery([$spanTermQuery1, $spanTermQuery2], 0);

        $spanContainingQuery = new SpanNotQuery($spanTermQuery, $spanNearQuery);
        $resultSet = $index->search($spanContainingQuery);
        $this->assertEquals(1, $resultSet->count());

        $spanNearQuery->setSlop(5);
        $spanContainingQuery = new SpanNotQuery($spanTermQuery, $spanNearQuery);
        $resultSet = $index->search($spanContainingQuery);
        $this->assertEquals(0, $resultSet->count());
    }
}
