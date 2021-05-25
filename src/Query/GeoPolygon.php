<?php

namespace Elastica\Query;

trigger_deprecation('ruflin/elastica', '7.2.0', 'The "%s" class is deprecated, use "%s" instead. It will be removed in 8.0.', GeoPolygon::class, GeoPolygonQuery::class);

/**
 * Geo polygon query.
 *
 * @author Michael Maclean <mgdm@php.net>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-polygon-query.html
 * @deprecated since version 7.2.0, use the GeoPolygonQuery class instead.
 */
class GeoPolygon extends GeoPolygonQuery
{
}
