<?php

namespace App\Models;

class FlightType
{
    const ONE_WAY = 'one-way';
    const ROUND_TRIP = 'round-trip';
    const MULTI_DESTINATION = 'multi-destination';

    public static function getFlightTypeList()
    {
        return [
            self::ONE_WAY => 'One way',
            self::ROUND_TRIP => 'Round trip',
            self::MULTI_DESTINATION => 'Multi destination'
        ];

    }

    public static function isOneWayTrip($type)
    {
        return $type === self::ONE_WAY;
    }

    public static function isRoundTrip($type)
    {
        return $type === self::ROUND_TRIP;
    }

    public static function isMultiDestinationTrip($type)
    {
        return $type === self::MULTI_DESTINATION;
    }

    public static function allowCorrespondence($type)
    {
        return self::isOneWayTrip($type) || self::isRoundTrip($type);
    }

}
