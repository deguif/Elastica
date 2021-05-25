<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', GeoBoundingBox::class, GeoBoundingBoxQuery::class);

/**
 * Geo bounding box query.
 *
 * @author Fabian Vogler <fabian@equivalence.ch>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-bounding-box-query.html
 * @deprecated since version 7.2.0, use the GeoBoundingBoxQuery class instead.
 */
class GeoBoundingBox extends GeoBoundingBoxQuery
{
}
