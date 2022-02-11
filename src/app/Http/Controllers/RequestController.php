<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Airport;

class RequestController extends Controller
{
    public static function getFormDataParameters(Request $request)
    {
        $formData = (array)json_decode($request->formData);
        $parameters = array();
        foreach ($formData as $key => $value) {
            if(strpos($key, '[')){
                $keyArr = explode('[', $key);
                $index = $keyArr[0];
                $indexKey = explode(']', $keyArr[1])[0];
                $parameters[$index][$indexKey] = self::buildChildrenParameter($keyArr[1], $value);
            } else {
                $parameters[$key] = $value;
            }
        }

        return $parameters;
    }

    private static function buildChildrenParameter($key, $value)
    {
        $keyArr = explode('][', $key);
        if(isset($keyArr[1]) && strpos($keyArr[1], '[')){
            $childrenArray = self::buildChildrenParameter($keyArr[1], $value);
        } else {
            $childrenArray = $value;
        }

        return $childrenArray;
    }
}
