<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', Prefix::class, PrefixQuery::class);

/**
 * Prefix query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-prefix-query.html
 * @deprecated since version 7.2.0, use the PrefixQuery class instead.
 */
class Prefix extends PrefixQuery
{
}
