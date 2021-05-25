<?php

namespace Elastica\Test\Query;

use Elastica\Index;
use Elastica\Mapping;
use Elastica\Query\AbstractQuery;
use Elastica\Query\HasChildQuery;
use Elastica\Query\InnerHitsQuery;
use Elastica\Query\MatchAllQuery;
use Elastica\Query\NestedQuery;
use Elastica\Query\SimpleQueryStringQuery;
use Elastica\ResultSet;
use Elastica\Script\Script;
use Elastica\Script\ScriptFields;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class InnerHitsQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testSetSize(): void
    {
        $innerHits = (new InnerHitsQuery())
            ->setSize(12)
        ;

        $this->assertSame(12, $innerHits->getParam('size'));
    }

    /**
     * @group unit
     */
    public function testSetFrom(): void
    {
        $innerHits = (new InnerHitsQuery())
            ->setFrom(12)
        ;

        $this->assertSame(12, $innerHits->getParam('from'));
    }

    /**
     * @group unit
     */
    public function testSetSort(): void
    {
        $sort = ['last_activity_date' => ['order' => 'desc']];
        $innerHits = (new InnerHitsQuery())
            ->setSort($sort)
        ;

        $this->assertSame($sort, $innerHits->getParam('sort'));
    }

    /**
     * @group unit
     */
    public function testSetSource(): void
    {
        $fields = ['title', 'tags'];
        $innerHits = (new InnerHitsQuery())
            ->setSource($fields)
        ;

        $this->assertSame($fields, $innerHits->getParam('_source'));
    }

    /**
     * @group unit
     */
    public function testSetVersion(): void
    {
        $innerHits = (new InnerHitsQuery())
            ->setVersion(true)
        ;

        $this->assertTrue($innerHits->getParam('version'));

        $innerHits->setVersion(false);

        $this->assertFalse($innerHits->getParam('version'));
    }

    /**
     * @group unit
     */
    public function testSetExplain(): void
    {
        $innerHits = (new InnerHitsQuery())
            ->setExplain(true)
        ;

        $this->assertTrue($innerHits->getParam('explain'));

        $innerHits->setExplain(false);

        $this->assertFalse($innerHits->getParam('explain'));
    }

    /**
     * @group unit
     */
    public function testSetHighlight(): void
    {
        $highlight = [
            'fields' => [
                'title',
            ],
        ];
        $innerHits = (new InnerHitsQuery())
            ->setHighlight($highlight)
        ;

        $this->assertSame($highlight, $innerHits->getParam('highlight'));
    }

    /**
     * @group unit
     */
    public function testSetFieldDataFields(): void
    {
        $fields = ['title', 'tags'];
        $innerHits = (new InnerHitsQuery())
            ->setFieldDataFields($fields)
        ;

        $this->assertSame($fields, $innerHits->getParam('docvalue_fields'));
    }

    /**
     * @group unit
     */
    public function testSetScriptFields(): void
    {
        $script = new Script('1 + 2');
        $scriptFields = new ScriptFields(['three' => $script]);

        $innerHits = (new InnerHitsQuery())
            ->setScriptFields($scriptFields)
        ;

        $this->assertSame($scriptFields, $innerHits->getParam('script_fields'));
    }

    /**
     * @group unit
     */
    public function testAddScriptField(): void
    {
        $script = new Script('2+3');
        $innerHits = (new InnerHitsQuery())
            ->addScriptField('five', $script)
        ;

        $this->assertSame(['five' => $script->toArray()], $innerHits->getParam('script_fields')->toArray());
    }

    /**
     * @group functional
     */
    public function testInnerHitsNested(): void
    {
        $queryString = new SimpleQueryStringQuery('windows newton', ['title', 'users.name']);
        $innerHits = new InnerHitsQuery();

        $results = $this->getNestedQuery($queryString, $innerHits);
        $firstResult = \current($results->getResults());

        $innerHitsResults = $firstResult->getInnerHits();

        $this->assertEquals(4, $firstResult->getId());
        $this->assertEquals('Newton', $innerHitsResults['users']['hits']['hits'][0]['_source']['name']);
    }

    /**
     * @group functional
     */
    public function testInnerHitsParentChildren(): void
    {
        $queryString = new SimpleQueryStringQuery('linux cool');
        $innerHits = new InnerHitsQuery();

        $results = $this->getParentChildQuery($queryString, $innerHits);
        $firstResult = \current($results->getResults());

        $innerHits = $firstResult->getInnerHits();

        $responses = $innerHits['answers']['hits']['hits'];
        $responsesId = [];

        foreach ($responses as $response) {
            $responsesId[] = $response['_id'];
        }

        $this->assertEquals(1, $firstResult->getId());
        $this->assertEquals([6, 7], $responsesId);
    }

    /**
     * @group functional
     */
    public function testInnerHitsLimitedSource(): void
    {
        $innerHits = (new InnerHitsQuery())
            ->setSource(['users.name'])
        ;

        $results = $this->getNestedQuery(new MatchAllQuery(), $innerHits);

        foreach ($results as $row) {
            $innerHitsResult = $row->getInnerHits();
            foreach ($innerHitsResult['users']['hits']['hits'] as $doc) {
                $this->assertArrayHasKey('name', $doc['_source']);
                $this->assertArrayNotHasKey('last_activity_date', $doc['_source']);
            }
        }
    }

    /**
     * @group functional
     */
    public function testInnerHitsWithOffset(): void
    {
        $queryString = new SimpleQueryStringQuery('linux cool');
        $innerHits = (new InnerHitsQuery())
            ->setFrom(1)
        ;

        $results = $this->getParentChildQuery($queryString, $innerHits);
        $firstResult = \current($results->getResults());

        $innerHits = $firstResult->getInnerHits();

        $responses = $innerHits['answers']['hits']['hits'];

        $this->assertCount(1, $responses);
        $this->assertEquals(7, $responses[0]['_id']);
    }

    /**
     * @group functional
     */
    public function testInnerHitsWithSort(): void
    {
        $queryString = new SimpleQueryStringQuery('linux cool');
        $innerHits = (new InnerHitsQuery())
            ->setSort(['answer' => 'asc'])
        ;

        $results = $this->getParentChildQuery($queryString, $innerHits);
        $firstResult = \current($results->getResults());

        $innerHits = $firstResult->getInnerHits();

        $responses = $innerHits['answers']['hits']['hits'];
        $responsesId = [];

        foreach ($responses as $response) {
            $responsesId[] = $response['_id'];
        }

        $this->assertEquals(1, $firstResult->getId());
        $this->assertEquals([7, 6], $responsesId);
    }

    /**
     * @group functional
     */
    public function testInnerHitsWithExplain(): void
    {
        $matchAll = new MatchAllQuery();
        $innerHits = (new InnerHitsQuery())
            ->setExplain(true)
        ;

        $results = $this->getNestedQuery($matchAll, $innerHits);

        foreach ($results as $row) {
            $innerHitsResult = $row->getInnerHits();
            foreach ($innerHitsResult['users']['hits']['hits'] as $doc) {
                $this->assertArrayHasKey('_explanation', $doc);
            }
        }
    }

    /**
     * @group functional
     */
    public function testInnerHitsWithVersion(): void
    {
        $matchAll = new MatchAllQuery();
        $innerHits = (new InnerHitsQuery())
            ->setVersion(true)
        ;

        $results = $this->getNestedQuery($matchAll, $innerHits);

        foreach ($results as $row) {
            $innerHitsResult = $row->getInnerHits();
            foreach ($innerHitsResult['users']['hits']['hits'] as $doc) {
                $this->assertArrayHasKey('_version', $doc);
            }
        }
    }

    /**
     * @group functional
     */
    public function testInnerHitsWithScriptFields(): void
    {
        $matchAll = new MatchAllQuery();
        $scriptFields = (new ScriptFields())
            ->addScript('three', new Script('1 + 2'))
            ->addScript('five', new Script('3 + 2'))
        ;
        $innerHits = (new InnerHitsQuery())
            ->setSize(1)
            ->setScriptFields($scriptFields)
        ;

        $results = $this->getNestedQuery($matchAll, $innerHits);

        foreach ($results as $row) {
            $innerHitsResult = $row->getInnerHits();
            foreach ($innerHitsResult['users']['hits']['hits'] as $doc) {
                $this->assertEquals(3, $doc['fields']['three'][0]);
                $this->assertEquals(5, $doc['fields']['five'][0]);
            }
        }
    }

    /**
     * @group functional
     */
    public function testInnerHitsWithHighlight(): void
    {
        $queryString = new SimpleQueryStringQuery('question simon', ['title', 'users.name']);
        $innerHits = (new InnerHitsQuery())
            ->setHighlight(['fields' => ['users.name' => new \stdClass()]])
        ;

        $results = $this->getNestedQuery($queryString, $innerHits);

        foreach ($results as $row) {
            $innerHitsResult = $row->getInnerHits();
            foreach ($innerHitsResult['users']['hits']['hits'] as $doc) {
                $this->assertArrayHasKey('highlight', $doc);
                if (\method_exists($this, 'assertMatchesRegularExpression')) {
                    $this->assertMatchesRegularExpression('#<em>Simon</em>#', $doc['highlight']['users.name'][0]);
                } else {
                    $this->assertRegExp('#<em>Simon</em>#', $doc['highlight']['users.name'][0]);
                }
            }
        }
    }

    /**
     * @group functional
     */
    public function testInnerHitsWithFieldData(): void
    {
        $queryString = new SimpleQueryStringQuery('question simon', ['title', 'users.name']);
        $innerHits = (new InnerHitsQuery())
            ->setFieldDataFields(['users.name'])
        ;

        $results = $this->getNestedQuery($queryString, $innerHits);

        foreach ($results as $row) {
            $innerHitsResult = $row->getInnerHits();
            foreach ($innerHitsResult['users']['hits']['hits'] as $doc) {
                $this->assertArrayHasKey('fields', $doc);
                $this->assertArrayHasKey('users.name', $doc['fields']);
                $this->assertArrayNotHasKey('users.last_activity_date', $doc['fields']);
            }
        }
    }

    private function _getIndexForNestedTest(): Index
    {
        $index = $this->_createIndex();
        $index->setMapping(new Mapping([
            'users' => [
                'type' => 'nested',
                'properties' => [
                    'name' => ['type' => 'text', 'fielddata' => true],
                    'last_activity_date' => ['type' => 'date'],
                ],
            ],
            'title' => ['type' => 'text'],
            'last_activity_date' => ['type' => 'date'],
        ]));

        $index->addDocuments([
            $index->createDocument(1, [
                'users' => [
                    ['name' => 'John Smith', 'last_activity_date' => '2015-01-05'],
                    ['name' => 'Conan', 'last_activity_date' => '2015-01-05'],
                ],
                'last_activity_date' => '2015-01-05',
                'title' => 'Question about linux #1',
            ]),
            $index->createDocument(2, [
                'users' => [
                    ['name' => 'John Doe', 'last_activity_date' => '2015-01-05'],
                    ['name' => 'Simon', 'last_activity_date' => '2015-01-05'],
                ],
                'last_activity_date' => '2014-12-23',
                'title' => 'Question about linux #2',
            ]),
            $index->createDocument(3, [
                'users' => [
                    ['name' => 'Simon', 'last_activity_date' => '2015-01-05'],
                    ['name' => 'Garfunkel', 'last_activity_date' => '2015-01-05'],
                ],
                'last_activity_date' => '2015-01-05',
                'title' => 'Question about windows #1',
            ]),
            $index->createDocument(4, [
                'users' => [
                    ['name' => 'Einstein'],
                    ['name' => 'Newton'],
                    ['name' => 'Maxwell'],
                ],
                'last_activity_date' => '2014-12-23',
                'title' => 'Question about windows #2',
            ]),
            $index->createDocument(5, [
                'users' => [
                    ['name' => 'Faraday'],
                    ['name' => 'Leibniz'],
                    ['name' => 'Descartes'],
                ],
                'last_activity_date' => '2014-12-23',
                'title' => 'Question about osx',
            ]),
        ]);

        $index->refresh();

        return $index;
    }

    private function _getIndexForParentChildrenTest(): Index
    {
        $index = $this->_createIndex();
        $mappingQuestion = new Mapping();
        $mappingQuestion->setProperties([
            'title' => ['type' => 'text'],
            'answer' => ['type' => 'text', 'fielddata' => true],
            'last_activity_date' => ['type' => 'date'],
            'my_join_field' => [
                'type' => 'join',
                'relations' => [
                    'questions' => 'answers',
                ],
            ],
        ]);

        $index->setMapping($mappingQuestion);
        $index->addDocuments([
            $index->createDocument(1, [
                'last_activity_date' => '2015-01-05',
                'title' => 'Question about linux #1',
                'my_join_field' => [
                    'name' => 'questions',
                ],
            ]),
            $index->createDocument(2, [
                'last_activity_date' => '2014-12-23',
                'title' => 'Question about linux #2',
                'my_join_field' => [
                    'name' => 'questions',
                ],
            ]),
            $index->createDocument(3, [
                'last_activity_date' => '2015-01-05',
                'title' => 'Question about windows #1',
                'my_join_field' => [
                    'name' => 'questions',
                ],
            ]),
            $index->createDocument(4, [
                'last_activity_date' => '2014-12-23',
                'title' => 'Question about windows #2',
                'my_join_field' => [
                    'name' => 'questions',
                ],
            ]),
            $index->createDocument(5, [
                'last_activity_date' => '2014-12-23',
                'title' => 'Question about osx',
                'my_join_field' => [
                    'name' => 'questions',
                ],
            ]),
        ]);

        $doc1 = $index->createDocument(6, [
            'answer' => 'linux is cool',
            'last_activity_date' => '2016-01-05',
            'my_join_field' => [
                'name' => 'answers',
                'parent' => 1,
            ],
        ]);

        $doc2 = $index->createDocument(7, [
            'answer' => 'linux is bad',
            'last_activity_date' => '2005-01-05',
            'my_join_field' => [
                'name' => 'answers',
                'parent' => 1,
            ],
        ]);

        $doc3 = $index->createDocument(8, [
            'answer' => 'windows was cool',
            'last_activity_date' => '2005-01-05',
            'my_join_field' => [
                'name' => 'answers',
                'parent' => 2,
            ],
        ]);

        $this->_getClient()->addDocuments([$doc1, $doc2, $doc3], ['routing' => 1]);

        $index->refresh();

        return $index;
    }

    private function getNestedQuery(AbstractQuery $query, InnerHitsQuery $innerHits): ResultSet
    {
        $nested = (new NestedQuery())
            ->setInnerHits($innerHits)
            ->setPath('users')
            ->setQuery($query)
        ;

        return $this->_getIndexForNestedTest()->search($nested);
    }

    private function getParentChildQuery(AbstractQuery $query, InnerHitsQuery $innerHits): ResultSet
    {
        $child = (new HasChildQuery($query, 'answers'))->setInnerHits($innerHits);

        return $this->_getIndexForParentChildrenTest()->search($child);
    }
}