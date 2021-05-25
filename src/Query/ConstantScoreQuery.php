<?php

namespace Elastica\Query;

/**
 * @author Nicolas Ruflin <spam@ruflin.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-constant-score-query.html
 */
class ConstantScoreQuery extends AbstractQuery
{
    public function __construct(?AbstractQuery $filter = null)
    {
        if (null !== $filter) {
            $this->setFilter($filter);
        }
    }

    /**
     * Set filter.
     *
     * @return $this
     */
    public function setFilter(AbstractQuery $filter): self
    {
        return $this->setParam('filter', $filter);
    }

    /**
     * Set boost.
     *
     * @return $this
     */
    public function setBoost(float $boost): self
    {
        return $this->setParam('boost', $boost);
    }
}
