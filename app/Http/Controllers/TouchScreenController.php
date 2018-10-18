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

        $json = file_get_contents('agenda.json');
        $json = json_decode($json, true);

        return $json;
    }

    public function expoStands(){
        $json = file_get_contents('expo.json');
        $json = json_decode($json, true);

        return $json;
    }
}
