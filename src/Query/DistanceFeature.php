<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', DistanceFeature::class, DistanceFeatureQuery::class);

/**
 * Distance feature query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-distance-feature-query.html
 * @deprecated since version 7.2.0, use the DistanceFeatureQuery class instead.
 */
class DistanceFeature extends DistanceFeatureQuery
{
}
