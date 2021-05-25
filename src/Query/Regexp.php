<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', Regexp::class, RegexpQuery::class);

/**
 * Regexp query.
 *
 * @author Aurélien Le Grand <gnitg@yahoo.fr>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-regexp-query.html
 * @deprecated since version 7.2.0, use the RegexpQuery class instead.
 */
class Regexp extends RegexpQuery
{
}
