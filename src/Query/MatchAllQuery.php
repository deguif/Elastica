<?php

namespace Elastica\Query;

/**
 * @author Nicolas Ruflin <spam@ruflin.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-all-query.html
 */
class MatchAllQuery extends AbstractQuery
{
    public function __construct()
    {
        $this->_params = new \stdClass();
    }
}
