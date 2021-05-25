<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', Limit::class, LimitQuery::class);

/**
 * Limit Query.
 *
 * @author Nicolas Ruflin <spam@ruflin.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-limit-query.html
 * @deprecated since version 7.2.0, use the LimitQuery class instead.
 */
class Limit extends LimitQuery
{
}
