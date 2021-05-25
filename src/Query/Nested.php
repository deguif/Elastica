<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', Nested::class, NestedQuery::class);

/**
 * Nested query.
 *
 * @author Nicolas Ruflin <spam@ruflin.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-nested-query.html
 * @deprecated since version 7.2.0, use the NestedQuery class instead.
 */
class Nested extends NestedQuery
{
}
