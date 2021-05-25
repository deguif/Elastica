<?php

namespace Elastica\Query;

/**
 * @author Nicolas Ruflin <spam@ruflin.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-limit-query.html
 */
class LimitQuery extends AbstractQuery
{
    public function __construct(int $limit)
    {
        $this->setLimit($limit);
    }

    /**
     * Set the limit.
     *
     * @return $this
     */
    public function setLimit(int $limit): self
    {
        return $this->setParam('value', $limit);
    }
}
