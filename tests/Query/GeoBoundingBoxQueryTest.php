<?php

namespace Elastica\Test\Query;

use Elastica\Exception\InvalidException;
use Elastica\Query\GeoBoundingBoxQuery;
use Elastica\Test\Base as BaseTest;

/**
 * @internal
 */
class GeoBoundingBoxQueryTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testAddCoordinates(): void
    {
        $key = 'pin.location';
        $coords = ['40.73, -74.1', '40.01, -71.12'];
        $query = new GeoBoundingBoxQuery($key, ['1,2', '3,4']);

        $query->addCoordinates($key, $coords);
        $expectedArray = ['top_left' => $coords[0], 'bottom_right' => $coords[1]];
        $this->assertSame($expectedArray, $query->getParam($key));
    }

    /**
     * @group unit
     */
    public function testAddCoordinatesInvalidException(): void
    {
        $this->expectException(InvalidException::class);

        new GeoBoundingBoxQuery('foo', []);
    }

    /**
     * @group unit
     */
    public function testToArray(): void
    {
        $key = 'pin.location';
        $coords = ['40.73, -74.1', '40.01, -71.12'];
        $query = new GeoBoundingBoxQuery($key, $coords);

        $expectedArray = [
            'geo_bounding_box' => [
                $key => [
                    'top_left' => $coords[0],
                    'bottom_right' => $coords[1],
                ],
            ],
        ];

        $this->assertEquals($expectedArray, $query->toArray());
    }
}