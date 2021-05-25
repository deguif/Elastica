<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', Percolate::class, PercolateQuery::class);

/**
 * Percolate query.
 *
 * @author Boris Popovschi <zyqsempai@mail.ru>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-percolate-query.html
 * @deprecated since version 7.2.0, use the PercolateQuery class instead.
 */
class Percolate extends PercolateQuery
{
}
