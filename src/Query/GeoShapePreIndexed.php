<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', GeoShapePreIndexed::class, GeoShapePreIndexedQuery::class);

/**
 * geo_shape query for pre-indexed shapes.
 *
 * Query pre-indexed shape definitions
 *
 * @author Bennie Krijger <benniekrijger@gmail.com>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-shape-query.html
 * @deprecated since version 7.2.0, use the GeoShapePreIndexedQuery class instead.
 */
class GeoShapePreIndexed extends GeoShapePreIndexedQuery
{
}
