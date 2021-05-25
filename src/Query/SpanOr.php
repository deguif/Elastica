<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', SpanOr::class, SpanOrQuery::class);

/**
 * SpanOr query.
 *
 * @author Marek Hernik <marek.hernik@gmail.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-term-query.html
 * @deprecated since version 7.2.0, use the SpanOrQuery class instead.
 */
class SpanOr extends SpanOrQuery
{
}
