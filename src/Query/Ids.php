<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', Ids::class, IdsQuery::class);

/**
 * Ids Query.
 *
 * @author Lee Parker
 * @author Nicolas Ruflin <spam@ruflin.com>
 * @author Tim Rupp
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-ids-query.html
 * @deprecated since version 7.2.0, use the IdsQuery class instead.
 */
class Ids extends IdsQuery
{
}
