<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Airport;

class TripController extends Controller
{
    public function index()
    {
        $airports = Airport::getAirportSelectList();
        $type = ['one-way' => 'One way', 'round-trip' => 'Round trip', 'multi-destination' => 'Multi destination'];

        return view('home', ['type' => $type, 'airports' => $airports]);
    }

    public function addStopover(Request $request)
    {
        $view = '';
        $nbStopover = (int)$request->nbStopover;
        if($nbStopover <= 5){
            $view = view('templates.newStopover', ['nbStopover' => $nbStopover]);
        }
        return $view;
    }
}
