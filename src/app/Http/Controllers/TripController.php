<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(){

        $type = ['one-way' => 'One way', 'round-trip' => 'Round trip', 'multi-destination' => 'Multi destination'];
        $airports = ['qq' => '1q1', 'ww' => '2w2', 'ee' => '3e3'];

        return view('home', ['type' => $type, 'airports' => $airports]);
    }
}
