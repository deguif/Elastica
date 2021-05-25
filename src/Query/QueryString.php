<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', QueryString::class, QueryStringQuery::class);

/**
 * QueryString query.
 *
 * @author Nicolas Ruflin <spam@ruflin.com>, Jasper van Wanrooy <jasper@vanwanrooy.net>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-query-string-query.html
 * @deprecated since version 7.2.0, use the QueryStringQuery class instead.
 */
class QueryString extends QueryStringQuery
{
}
