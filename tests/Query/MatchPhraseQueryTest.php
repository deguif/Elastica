<?php

namespace Elastica\Test\Query;

use Elastica\Document;
use Elastica\Query;
use Elastica\Query\MatchPhraseQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class MatchPhraseQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testToArray(): void
    {
        $field = 'test';
        $testQuery = 'Nicolas Ruflin';
        $analyzer = 'myanalyzer';
        $boost = 2.0;

        $query = new MatchPhraseQuery();
        $query->setFieldQuery($field, $testQuery);
        $query->setFieldAnalyzer($field, $analyzer);
        $query->setFieldBoost($field, $boost);

        $expectedArray = [
            'match_phrase' => [
                $field => [
                    'query' => $testQuery,
                    'analyzer' => $analyzer,
                    'boost' => $boost,
                ],
            ],
        ];

        $this->assertEquals($expectedArray, $query->toArray());
    }

    /**
     * @group functional
     */
    public function testMatchPhrase(): void
    {
        $client = $this->_getClient();
        $index = $client->getIndex('test');
        $index->create([], [
            'recreate' => true,
        ]);

        $index->addDocuments([
            new Document(1, ['name' => 'Basel-Stadt']),
            new Document(2, ['name' => 'New York']),
            new Document(3, ['name' => 'New Hampshire']),
            new Document(4, ['name' => 'Basel Land']),
        ]);

        $index->refresh();

        $query = new MatchPhraseQuery();
        $query->setFieldQuery('name', 'New York');

        $resultSet = $index->search($query);

        $this->assertEquals(1, $resultSet->count());
    }

    /**
     * @group functional
     */
    public function testHighlightSearch(): void
    {
        $index = $this->_createIndex();

        $phrase = 'My name is ruflin';

        $index->addDocuments([
            new Document(1, ['id' => 1, 'phrase' => $phrase, 'username' => 'hanswurst', 'test' => ['2', '3', '5']]),
            new Document(2, ['id' => 2, 'phrase' => $phrase, 'username' => 'peter', 'test' => ['2', '3', '5']]),
        ]);

        $matchQuery = new MatchPhraseQuery('phrase', 'ruflin');
        $query = (new Query($matchQuery))
            ->setHighlight([
                'pre_tags' => ['<em class="highlight">'],
                'post_tags' => ['</em>'],
                'fields' => [
                    'phrase' => [
                        'fragment_size' => 200,
                        'number_of_fragments' => 1,
                    ],
                ],
            ])
        ;

        $index->refresh();

        $resultSet = $index->search($query);

        foreach ($resultSet as $result) {
            $highlight = $result->getHighlights();
            $this->assertEquals(['phrase' => [0 => 'My name is <em class="highlight">ruflin</em>']], $highlight);
        }
        $this->assertEquals(2, $resultSet->count());
    }
}
