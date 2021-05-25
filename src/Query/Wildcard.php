<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', Wildcard::class, WildcardQuery::class);

/**
 * Wildcard query.
 *
 * @author Nicolas Ruflin <spam@ruflin.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-wildcard-query.html
 * @deprecated since version 7.2.0, use the WildcardQuery class instead.
 */
class Wildcard extends WildcardQuery
{
}
