<?php

namespace Elastica\Test\QueryBuilder\DSL;

use Elastica\Query;
use Elastica\Query\MatchQuery;
use Elastica\QueryBuilder\DSL;

/**
 * @internal
 */
class QueryTest extends AbstractDSLTest
{
    /**
     * @group unit
     */
    public function testType(): void
    {
        $queryDSL = new DSL\Query();

        $this->assertInstanceOf(DSL::class, $queryDSL);
        $this->assertEquals(DSL::TYPE_QUERY, $queryDSL->getType());
    }

    /**
     * @group unit
     */
    public function testMatch(): void
    {
        $match = (new DSL\Query())
            ->match('field', 'value')
        ;

        $this->assertEquals('value', $match->getParam('field'));
    }

    /**
     * @group unit
     */
    public function testInterface(): void
    {
        $queryDSL = new DSL\Query();

        $this->_assertImplemented($queryDSL, 'bool', Query\BoolQuery::class, []);
        $this->_assertImplemented($queryDSL, 'boosting', Query\BoostingQuery::class, []);
        $this->_assertImplemented($queryDSL, 'common_terms', Query\CommonQuery::class, ['field', 'query', 0.001]);
        $this->_assertImplemented($queryDSL, 'dis_max', Query\DisMaxQuery::class, []);
        $this->_assertImplemented($queryDSL, 'distance_feature', Query\DistanceFeatureQuery::class, ['field', 'now', '7d']);
        $this->_assertImplemented($queryDSL, 'function_score', Query\FunctionScoreQuery::class, []);
        $this->_assertImplemented($queryDSL, 'fuzzy', Query\FuzzyQuery::class, ['field', 'type']);
        $this->_assertImplemented($queryDSL, 'has_child', Query\HasChildQuery::class, [new MatchQuery()]);
        $this->_assertImplemented($queryDSL, 'has_parent', Query\HasParentQuery::class, [new MatchQuery(), 'type']);
        $this->_assertImplemented($queryDSL, 'ids', Query\IdsQuery::class, [[]]);
        $this->_assertImplemented($queryDSL, 'match', MatchQuery::class, ['field', 'values']);
        $this->_assertImplemented($queryDSL, 'match_all', Query\MatchAllQuery::class, []);
        $this->_assertImplemented($queryDSL, 'match_none', Query\MatchNoneQuery::class, []);
        $this->_assertImplemented($queryDSL, 'more_like_this', Query\MoreLikeThisQuery::class, []);
        $this->_assertImplemented($queryDSL, 'multi_match', Query\MultiMatchQuery::class, []);
        $this->_assertImplemented($queryDSL, 'nested', Query\NestedQuery::class, []);
        $this->_assertImplemented($queryDSL, 'parent_id', Query\ParentIdQuery::class, ['test', 1]);
        $this->_assertImplemented($queryDSL, 'prefix', Query\PrefixQuery::class, []);
        $this->_assertImplemented($queryDSL, 'query_string', Query\QueryStringQuery::class, []);
        $this->_assertImplemented($queryDSL, 'range', Query\RangeQuery::class, ['field', []]);
        $this->_assertImplemented($queryDSL, 'regexp', Query\RegexpQuery::class, ['field', 'value', 1.0]);
        $this->_assertImplemented($queryDSL, 'simple_query_string', Query\SimpleQueryStringQuery::class, ['query']);
        $this->_assertImplemented($queryDSL, 'term', Query\TermQuery::class, []);
        $this->_assertImplemented($queryDSL, 'terms', Query\TermsQuery::class, ['field', []]);
        $this->_assertImplemented($queryDSL, 'wildcard', Query\WildcardQuery::class, ['field', '']);
        $this->_assertImplemented($queryDSL, 'geo_distance', Query\GeoDistanceQuery::class, ['key', ['lat' => 1, 'lon' => 0], 'distance']);
        $this->_assertImplemented($queryDSL, 'exists', Query\ExistsQuery::class, ['field']);
        $this->_assertImplemented($queryDSL, 'span_term', Query\SpanTermQuery::class, []);
        $this->_assertImplemented($queryDSL, 'span_multi_term', Query\SpanMultiQuery::class, []);
        $this->_assertImplemented($queryDSL, 'span_near', Query\SpanNearQuery::class, []);
        $this->_assertImplemented($queryDSL, 'span_or', Query\SpanOrQuery::class, []);
        $this->_assertImplemented($queryDSL, 'span_first', Query\SpanFirstQuery::class, []);
        $this->_assertImplemented($queryDSL, 'span_containing', Query\SpanContainingQuery::class, []);
        $this->_assertImplemented($queryDSL, 'span_within', Query\SpanWithinQuery::class, []);
        $this->_assertImplemented($queryDSL, 'span_not', Query\SpanNotQuery::class, []);
    }
}
