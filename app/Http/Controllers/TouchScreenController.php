<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TouchScreenController extends Controller
{
    //

    public function index(){

        return view("Touchscreen.index");
    }

    public function schedule(){

        $json = file_get_contents('http://testing.otew.io/api/touch-screen/get-agenda');
        $json = json_decode($json, true);

        return $json;
    }
}
