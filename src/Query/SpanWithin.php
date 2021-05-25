<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', SpanWithin::class, SpanWithinQuery::class);

/**
 * SpanWithin query.
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-within-query.html
 * @deprecated since version 7.2.0, use the SpanWithinQuery class instead.
 */
class SpanWithin extends SpanWithinQuery
{
}
