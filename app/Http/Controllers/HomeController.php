<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\DB;
use RuntimeException;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = DB::table('screen_settings')->get();
        return view('home')->with('settings',$settings);
    }


}
