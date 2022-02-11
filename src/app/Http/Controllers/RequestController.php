<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Airport;

class RequestController extends Controller
{
    public static function getFormDataParameters(Request $request)
    {
        $formData = json_decode($request->formData);
        $parameters = array();
        $dataArr = explode('&', urldecode($formData));
        foreach ($dataArr as $data) {
            $dataEx = explode('=', $data);
            $key = $dataEx[0];
            $value = $dataEx[1];
            if(strpos($key, '[')){
                $keyArr = explode('[', $key);
                $indexArray = array();
//                foreach ($keyArr as $subKey){
//                    $subBeyArr = explode(']', $subKey);
//                    $indexArray[] = $subBeyArr[0];
//                }
//                for($i = 1; count($indexArray) <=12; $i++) {
//                    $parameters[$i] = $parameters[$i+1];
//
//                }
//                    for($i = count($indexArray); $i === 1; $i--) {
////                    $parameters[$i] =
//                }
//
                $index = $keyArr[0];
                $indexKey = substr($keyArr[1], 0, 1);
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
        $index = substr($keyArr[0], 0, 1);
        if(isset($keyArr[1]) && strpos($keyArr[1], '[')){
            $childrenArray = self::buildChildrenParameter($keyArr[1], $value);
        } else {
            $childrenArray[$index] = $value;
        }

        return $childrenArray;
    }
}
