<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', Boosting::class, BoostingQuery::class);

/**
 * Class Boosting.
 *
 * @author Balazs Nadasdi <yitsushi@gmail.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-boosting-query.html
 * @deprecated since version 7.2.0, use the BoostingQuery class instead.
 */
class Boosting extends BoostingQuery
{
}
