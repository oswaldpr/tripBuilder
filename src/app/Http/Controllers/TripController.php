<?php

namespace App\Http\Controllers;

use App\Models\Airport;

class TripController extends Controller
{
    public function index()
    {
        $airports = Airport::getAirportSelectList();
        $type = ['one-way' => 'One way', 'round-trip' => 'Round trip', 'multi-destination' => 'Multi destination'];

        return view('home', ['type' => $type, 'airports' => $airports]);
    }
}
