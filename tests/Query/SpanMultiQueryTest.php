<?php

namespace Elastica\Test\Query;

use Elastica\Document;
use Elastica\Query\FuzzyQuery;
use Elastica\Query\PrefixQuery;
use Elastica\Query\RegexpQuery;
use Elastica\Query\SpanMultiQuery;
use Elastica\Query\WildcardQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class SpanMultiQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testConstructValid(): void
    {
        $field = 'name';
        $value = 'marek';

        $spanMultiQuery = new SpanMultiQuery(new RegexpQuery($field, $value, 0.7));
        $expected = [
            'span_multi' => [
                'match' => [
                    'regexp' => [
                        $field => [
                            'value' => $value,
                            'boost' => 0.7,
                        ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $spanMultiQuery->toArray());

        $spanMultiQuery = new SpanMultiQuery();
        $spanMultiQuery->setMatch(new FuzzyQuery($field, $value));
        $expected = [
            'span_multi' => [
                'match' => [
                    'fuzzy' => [
                        $field => [
                            'value' => $value,
                        ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $spanMultiQuery->toArray());
    }

    /**
     * @group functional
     */
    public function testSpanMulti(): void
    {
        $field = 'lorem';
        $text1 = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        $text2 = 'Praesent gravida nisi in lorem consectetur, vel ullamcorper leo iaculis.';
        $text3 = 'Vivamus vitae mi nec tortor iaculis pellentesque at nec ipsum.';
        $text4 = 'Donec tempor feugiat sapien, ac porta metus hendrerit nec';
        $text5 = 'Nullam pharetra mi vitae sollicitudin fermentum. Proin sed enim consequat, consectetur eros vitae, egestas metus';

        $index = $this->_createIndex();

        $index->addDocuments([
            new Document(1, [$field => $text1]),
            new Document(2, [$field => $text2]),
            new Document(3, [$field => $text3]),
            new Document(4, [$field => $text4]),
            new Document(5, [$field => $text5]),
        ]);
        $index->refresh();

        $spanMultiQuery = new SpanMultiQuery();

        //multi with prefix will match 3
        $prefixQuery = new PrefixQuery([$field => ['value' => 'conse']]);
        $spanMultiQuery->setMatch($prefixQuery);
        $resultSet = $index->search($spanMultiQuery);
        $this->assertEquals(3, $resultSet->count());

        //multi with wildcard will match 3
        $wildcardQuery = new WildcardQuery($field, '*ll*');
        $spanMultiQuery->setMatch($wildcardQuery);
        $resultSet = $index->search($spanMultiQuery);
        $this->assertEquals(3, $resultSet->count());
    }
}
