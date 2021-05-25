<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', MatchNone::class, MatchNoneQuery::class);

/**
 * Match none query. Returns no results.
 *
 * @author David Causse
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-all-query.html#query-dsl-match-none-query
 * @deprecated since version 7.2.0, use the MatchNoneQuery class instead.
 */
class MatchNone extends MatchNoneQuery
{
}
