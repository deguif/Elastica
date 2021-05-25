<?php

namespace Elastica\QueryBuilder\DSL;

use Elastica\Query\AbstractQuery;
use Elastica\Query\AbstractSpanQuery;
use Elastica\Query as BaseQuery;
use Elastica\Query\BoolQuery;
use Elastica\Query\BoostingQuery;
use Elastica\Query\CommonQuery;
use Elastica\Query\ConstantScoreQuery;
use Elastica\Query\DisMaxQuery;
use Elastica\Query\DistanceFeatureQuery;
use Elastica\Query\ExistsQuery;
use Elastica\Query\FunctionScoreQuery;
use Elastica\Query\FuzzyQuery;
use Elastica\Query\GeoBoundingBoxQuery;
use Elastica\Query\GeoDistanceQuery;
use Elastica\Query\GeoPolygonQuery;
use Elastica\Query\HasChildQuery;
use Elastica\Query\HasParentQuery;
use Elastica\Query\IdsQuery;
use Elastica\Query\MatchAllQuery;
use Elastica\Query\MatchNoneQuery;
use Elastica\Query\MatchPhrasePrefixQuery;
use Elastica\Query\MatchPhraseQuery;
use Elastica\Query\MatchQuery;
use Elastica\Query\MoreLikeThisQuery;
use Elastica\Query\MultiMatchQuery;
use Elastica\Query\NestedQuery;
use Elastica\Query\ParentIdQuery;
use Elastica\Query\PercolateQuery;
use Elastica\Query\PrefixQuery;
use Elastica\Query\QueryStringQuery;
use Elastica\Query\RangeQuery;
use Elastica\Query\RegexpQuery;
use Elastica\Query\SimpleQueryStringQuery;
use Elastica\Query\SpanContainingQuery;
use Elastica\Query\SpanFirstQuery;
use Elastica\Query\SpanMultiQuery;
use Elastica\Query\SpanNearQuery;
use Elastica\Query\SpanNotQuery;
use Elastica\Query\SpanOrQuery;
use Elastica\Query\SpanTermQuery;
use Elastica\Query\SpanWithinQuery;
use Elastica\Query\TermQuery;
use Elastica\Query\TermsQuery;
use Elastica\Query\WildcardQuery;
use Elastica\QueryBuilder\DSL;

/**
 * elasticsearch query DSL.
 *
 * @author Manuel Andreo Garcia <andreo.garcia@googlemail.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-queries.html
 */
class Query implements DSL
{
    /**
     * must return type for QueryBuilder usage.
     */
    public function getType(): string
    {
        return self::TYPE_QUERY;
    }

    /**
     * match query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query.html
     *
     * @param mixed $values
     */
    public function match(?string $field = null, $values = null): MatchQuery
    {
        return new MatchQuery($field, $values);
    }

    /**
     * multi match query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-multi-match-query.html
     */
    public function multi_match(): MultiMatchQuery
    {
        return new MultiMatchQuery();
    }

    /**
     * bool query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-bool-query.html
     */
    public function bool(): BoolQuery
    {
        return new BoolQuery();
    }

    /**
     * boosting query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-boosting-query.html
     */
    public function boosting(): BoostingQuery
    {
        return new BoostingQuery();
    }

    /**
     * common terms query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-common-terms-query.html
     *
     * @param float $cutoffFrequency percentage in decimal form (.001 == 0.1%)
     */
    public function common_terms(string $field, string $query, float $cutoffFrequency): CommonQuery
    {
        return new CommonQuery($field, $query, $cutoffFrequency);
    }

    /**
     * constant score query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-constant-score-query.html
     */
    public function constant_score(?AbstractQuery $filter = null): ConstantScoreQuery
    {
        return new ConstantScoreQuery($filter);
    }

    /**
     * dis max query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-dis-max-query.html
     */
    public function dis_max(): DisMaxQuery
    {
        return new DisMaxQuery();
    }

    /**
     * distance feature query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-distance-feature-query.html
     *
     * @param array|string $origin
     */
    public function distance_feature(string $field, $origin, string $pivot): DistanceFeatureQuery
    {
        return new DistanceFeatureQuery($field, $origin, $pivot);
    }

    /**
     * function score query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-function-score-query.html
     */
    public function function_score(): FunctionScoreQuery
    {
        return new FunctionScoreQuery();
    }

    /**
     * fuzzy query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-fuzzy-query.html
     *
     * @param string $value String to search for
     */
    public function fuzzy(?string $fieldName = null, ?string $value = null): FuzzyQuery
    {
        return new FuzzyQuery($fieldName, $value);
    }

    /**
     * geo bounding box query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-bounding-box-query.html
     */
    public function geo_bounding_box(string $key, array $coordinates): GeoBoundingBoxQuery
    {
        return new GeoBoundingBoxQuery($key, $coordinates);
    }

    /**
     * geo distance query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-distance-query.html
     *
     * @param array|string $location
     */
    public function geo_distance(string $key, $location, string $distance): GeoDistanceQuery
    {
        return new GeoDistanceQuery($key, $location, $distance);
    }

    /**
     * geo polygon query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-polygon-query.html
     */
    public function geo_polygon(string $key, array $points): GeoPolygonQuery
    {
        return new GeoPolygonQuery($key, $points);
    }

    /**
     * has child query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-has-child-query.html
     *
     * @param AbstractQuery|BaseQuery|string $query
     * @param string                         $type  Parent document type
     */
    public function has_child($query, ?string $type = null): HasChildQuery
    {
        return new HasChildQuery($query, $type);
    }

    /**
     * has parent query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-has-parent-query.html
     *
     * @param AbstractQuery|BaseQuery|string $query
     * @param string                         $type  Parent document type
     */
    public function has_parent($query, string $type): HasParentQuery
    {
        return new HasParentQuery($query, $type);
    }

    /**
     * ids query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-ids-query.html
     */
    public function ids(array $ids = []): IdsQuery
    {
        return new IdsQuery($ids);
    }

    /**
     * match all query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-all-query.html
     */
    public function match_all(): MatchAllQuery
    {
        return new MatchAllQuery();
    }

    /**
     * match none query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-all-query.html#query-dsl-match-none-query
     */
    public function match_none(): MatchNoneQuery
    {
        return new MatchNoneQuery();
    }

    /**
     * match phrase query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query-phrase.html
     *
     * @param mixed|null $values
     */
    public function match_phrase(?string $field = null, $values = null): MatchPhraseQuery
    {
        return new MatchPhraseQuery($field, $values);
    }

    /**
     * match phrase prefix query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query-phrase-prefix.html
     *
     * @param mixed|null $values
     */
    public function match_phrase_prefix(?string $field = null, $values = null): MatchPhrasePrefixQuery
    {
        return new MatchPhrasePrefixQuery($field, $values);
    }

    /**
     * more like this query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-mlt-query.html
     */
    public function more_like_this(): MoreLikeThisQuery
    {
        return new MoreLikeThisQuery();
    }

    /**
     * nested query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-nested-query.html
     */
    public function nested(): NestedQuery
    {
        return new NestedQuery();
    }

    /**
     * @param int|string $id
     */
    public function parent_id(string $type, $id, bool $ignoreUnmapped = false): ParentIdQuery
    {
        return new ParentIdQuery($type, $id, $ignoreUnmapped);
    }

    /**
     * prefix query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-prefix-query.html
     *
     * @param array $prefix Prefix array
     */
    public function prefix(array $prefix = []): PrefixQuery
    {
        return new PrefixQuery($prefix);
    }

    /**
     * query string query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-query-string-query.html
     *
     * @param string $queryString OPTIONAL Query string for object
     */
    public function query_string(string $queryString = ''): QueryStringQuery
    {
        return new QueryStringQuery($queryString);
    }

    /**
     * simple_query_string query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-simple-query-string-query.html
     */
    public function simple_query_string(string $query, array $fields = []): SimpleQueryStringQuery
    {
        return new SimpleQueryStringQuery($query, $fields);
    }

    /**
     * range query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-range-query.html
     */
    public function range(?string $fieldName = null, array $args = []): RangeQuery
    {
        return new RangeQuery($fieldName, $args);
    }

    /**
     * regexp query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-regexp-query.html
     */
    public function regexp(string $key = '', ?string $value = null, float $boost = 1.0): RegexpQuery
    {
        return new RegexpQuery($key, $value, $boost);
    }

    /**
     * span first query.
     *
     * @param AbstractQuery|array $match
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-first-query.html
     */
    public function span_first($match = null, ?int $end = null): SpanFirstQuery
    {
        return new SpanFirstQuery($match, $end);
    }

    /**
     * span multi term query.
     *
     * @param AbstractQuery|array $match
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-multi-term-query.html
     */
    public function span_multi_term($match = null): SpanMultiQuery
    {
        return new SpanMultiQuery($match);
    }

    /**
     * span near query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-near-query.html
     */
    public function span_near(array $clauses = [], int $slop = 1, bool $inOrder = false): SpanNearQuery
    {
        return new SpanNearQuery($clauses, $slop, $inOrder);
    }

    /**
     * span not query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-not-query.html
     */
    public function span_not(?AbstractSpanQuery $include = null, ?AbstractSpanQuery $exclude = null): SpanNotQuery
    {
        return new SpanNotQuery($include, $exclude);
    }

    /**
     * span_or query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-or-query.html
     */
    public function span_or(array $clauses = []): SpanOrQuery
    {
        return new SpanOrQuery($clauses);
    }

    /**
     * span_term query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-term-query.html
     */
    public function span_term(array $term = []): SpanTermQuery
    {
        return new SpanTermQuery($term);
    }

    /**
     * span_containing query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-containing-query.html
     */
    public function span_containing(?AbstractSpanQuery $little = null, ?AbstractSpanQuery $big = null): SpanContainingQuery
    {
        return new SpanContainingQuery($little, $big);
    }

    /**
     * span_within query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-within-query.html
     */
    public function span_within(?AbstractSpanQuery $little = null, ?AbstractSpanQuery $big = null): SpanWithinQuery
    {
        return new SpanWithinQuery($little, $big);
    }

    /**
     * term query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-term-query.html
     */
    public function term(array $term = []): TermQuery
    {
        return new TermQuery($term);
    }

    /**
     * terms query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-terms-query.html
     */
    public function terms(string $field, array $terms = []): TermsQuery
    {
        return new TermsQuery($field, $terms);
    }

    /**
     * wildcard query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-wildcard-query.html
     */
    public function wildcard(string $field, string $value, float $boost = 1.0): WildcardQuery
    {
        return new WildcardQuery($field, $value, $boost);
    }

    /**
     * exists query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-exists-query.html
     */
    public function exists(string $field): ExistsQuery
    {
        return new ExistsQuery($field);
    }

    /**
     * type query.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-percolate-query.html
     */
    public function percolate(): PercolateQuery
    {
        return new PercolateQuery();
    }
}
