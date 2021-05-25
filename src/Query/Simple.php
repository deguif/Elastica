<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', Simple::class, SimpleQuery::class);

/**
 * Simple query
 * Pure php array query. Can be used to create any not existing type of query.
 *
 * @author Nicolas Ruflin <spam@ruflin.com>
 *
 * @deprecated since version 7.2.0, use the SimpleQuery class instead.
 */
class Simple extends SimpleQuery
{
}
