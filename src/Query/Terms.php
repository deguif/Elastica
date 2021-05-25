<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', Terms::class, TermsQuery::class);

/**
 * Terms query.
 *
 * @author Nicolas Ruflin <spam@ruflin.com>
 * @author Roberto Nygaard <roberto@nygaard.es>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-terms-query.html
 * @deprecated since version 7.2.0, use the TermsQuery class instead.
 */
class Terms extends TermsQuery
{
}
