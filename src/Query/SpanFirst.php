<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', SpanFirst::class, SpanFirstQuery::class);

/**
 * SpanFirst query.
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-first-query.html
 * @deprecated since version 7.2.0, use the SpanFirstQuery class instead.
 */
class SpanFirst extends SpanFirstQuery
{
}
