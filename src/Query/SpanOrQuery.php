<?php

namespace Elastica\Query;

use Elastica\Exception\InvalidException;

/**
 * @author Marek Hernik <marek.hernik@gmail.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-term-query.html
 */
class SpanOrQuery extends AbstractSpanQuery
{
    /**
     * @param AbstractSpanQuery[] $clauses
     */
    public function __construct(array $clauses = [])
    {
        if (!empty($clauses)) {
            foreach ($clauses as $clause) {
                if (!$clause instanceof AbstractSpanQuery) {
                    throw new InvalidException('Invalid parameter. Has to be array or instance of '.AbstractSpanQuery::class);
                }
            }
        }
        $this->setParams(['clauses' => $clauses]);
    }

    /**
     * Add clause part to query.
     *
     * @throws InvalidException If not valid query
     *
     * @return $this
     */
    public function addClause(AbstractSpanQuery $clause): self
    {
        return $this->addParam('clauses', $clause);
    }
}
