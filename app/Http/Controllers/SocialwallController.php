<?php

namespace App\Http\Controllers;

use App\ScreenSetting;
use Illuminate\Http\Request;
use App\Leaderboard;
use App\mLeaderboard;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;
class SocialwallController extends Controller
{
    public function index()
    {
        return view('socialwall');
    }

    public function live()
    {
       // $leaderboards = Leaderboard::all();
      //  $countDown = ScreenSetting::where('screen','countdown')->first();

     //   if($countDown->status)
       //     return view('countdown');
      //  else
            //return view('socialwall')->with('leaderboards', $leaderboards);
            
            return ('<h1> Leaderboard Placeholder </h1>');
    }
    
    public function socialreact()
    {
    
        return view('social-react');
    
    
    }
	
	public function twitterwall()
	{
		return view('twitter');
	}

    public function mobileSocialwall()
    {
    // header('Access-Control-Allow-Origin: *');
        header('X-Frame-Options: *');
        $leaderboards = mLeaderboard::all();
        $countDown = ScreenSetting::where('screen','countdown')->first();

        if($countDown->status)
            return view('countdown');
        else
            return view('mobile-socialwall')->with('leaderboards', $leaderboards);
	    
	    
    }
	
	public function countdown()
	{
		return view('countdown');
		
	}

    public function debug()
    {
        $leaderboards = Leaderboard::all();
        return view('socialwall')->with('leaderboards', $leaderboards);
    }

    public function refresh()
    {
        $options = array(
            'encrypted' => true
        );
        $pusher = new Pusher(
            'dac400fc0f200416ae79',
            'ec80fcdbaf62a9a54a1f',
            '360459',
            $options
        );

        $data['message'] = 'Leaderboard is refreshing';
        $pusher->trigger('otew-channel', 'ot-refresh', $data);
        $statusCode = 200;
        $response = array('status' => 'ok', 'code' => $statusCode, $data);

        return back()->with(['flash_success' => 'Leaderboard Refreshed']);

    }

    public function mobileRefresh()
    {
      $options = array(
          'encrypted' => true
        );

      $pusher = new Pusher(
         'cd07fe7bf8a634a4d4e2',
         '6c5667d88eb58863baa0',
         '557685',
         $options
      );

      $data['message'] = 'Mobile Screen is Refreshing';
      $pusher->trigger('otew-channel', 'mt-refresh', $data);
      $statusCode = 200;
      $response = array('status' => 'ok', 'code' => $statusCode, $data);
      
      return back()->with(['flash_sucess' => 'Mobile Screen Refreshed']);

    }

    public function enableScreen($id){


        DB::table('screen_settings')->where('id',$id)->update(['status'=>true]);
        return back()->with(['flash_success' => 'Screen enabled']);


    }

    public function disableScreen($id){
        DB::table('screen_settings')->where('id',$id)->update(['status'=>false]);
        return back()->with(['flash_success' => 'Screen disabled']);
    }






}
