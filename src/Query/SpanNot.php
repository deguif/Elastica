<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', SpanNot::class, SpanNotQuery::class);

/**
 * SpanNot query.
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-not-query.html
 * @deprecated since version 7.2.0, use the SpanNotQuery class instead.
 */
class SpanNot extends SpanNotQuery
{
}
