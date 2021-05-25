<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', FunctionScore::class, FunctionScoreQuery::class);

/**
 * Class FunctionScore.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-function-score-query.html
 * @deprecated since version 7.2.0, use the FunctionScoreQuery class instead.
 */
class FunctionScore extends FunctionScoreQuery
{
}
