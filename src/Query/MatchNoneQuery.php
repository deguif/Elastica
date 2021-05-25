<?php

namespace Elastica\Query;

/**
 * @author David Causse
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-all-query.html#query-dsl-match-none-query
 */
class MatchNoneQuery extends AbstractQuery
{
    public function __construct()
    {
        $this->_params = new \stdClass();
    }
}
