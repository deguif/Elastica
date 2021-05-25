<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', HasChild::class, HasChildQuery::class);

/**
 * Returns parent documents having child docs matching the query.
 *
 * @author Fabian Vogler <fabian@equivalence.ch>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-has-child-query.html
 * @deprecated since version 7.2.0, use the HasChildQuery class instead.
 */
class HasChild extends HasChildQuery
{
}
