<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', SpanNear::class, SpanNearQuery::class);

/**
 * SpanNear query.
 *
 * @author Marek Hernik <marek.hernik@gmail.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-near-query.html
 * @deprecated since version 7.2.0, use the SpanNearQuery class instead.
 */
class SpanNear extends SpanNearQuery
{
}
