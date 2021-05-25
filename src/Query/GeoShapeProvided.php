<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', GeoShapeProvided::class, GeoShapeProvidedQuery::class);

/**
 * geo_shape query for provided shapes.
 *
 * Query provided shape definitions
 *
 * @author BennieKrijger <benniekrijger@gmail.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-shape-query.html
 * @deprecated since version 7.2.0, use the GeoShapeProvidedQuery class instead.
 */
class GeoShapeProvided extends GeoShapeProvidedQuery
{
}
