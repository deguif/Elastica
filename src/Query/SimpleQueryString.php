<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', SimpleQueryString::class, SimpleQueryStringQuery::class);

/**
 * Class SimpleQueryString.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-simple-query-string-query.html
 * @deprecated since version 7.2.0, use the SimpleQueryStringQuery class instead.
 */
class SimpleQueryString extends SimpleQueryStringQuery
{
}
