<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', MultiMatch::class, MultiMatchQuery::class);

/**
 * Multi Match.
 *
 * @author Rodolfo Adhenawer Campagnoli Moraes <adhenawer@gmail.com>
 * @author Wong Wing Lun <luiges90@gmail.com>
 * @author Tristan Maindron <tmaindron@gmail.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-multi-match-query.html
 * @deprecated since version 7.2.0, use the MultiMatchQuery class instead.
 */
class MultiMatch extends MultiMatchQuery
{
}
