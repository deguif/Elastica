<?php

namespace Elastica\Query;

/**
 * @author Michael Maclean <mgdm@php.net>
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-polygon-query.html
 */
class GeoPolygonQuery extends AbstractQuery
{
    /**
     * @var string Key
     */
    protected $_key;

    /**
     * @var array Points making up polygon
     */
    protected $_points;

    /**
     * @param array $points Points making up polygon
     */
    public function __construct(string $key, array $points)
    {
        $this->_key = $key;
        $this->_points = $points;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'geo_polygon' => [
                $this->_key => [
                    'points' => $this->_points,
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return \count($this->_points);
    }
}
