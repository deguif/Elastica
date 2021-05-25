<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', DisMax::class, DisMaxQuery::class);

/**
 * DisMax query.
 *
 * @author Hung Tran <oohnoitz@gmail.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-dis-max-query.html
 * @deprecated since version 7.2.0, use the DisMaxQuery class instead.
 */
class DisMax extends DisMaxQuery
{
}
