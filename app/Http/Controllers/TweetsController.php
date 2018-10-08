<?php

namespace App\Http\Controllers;

use App\TweetMedia;
use Auth;
use App\Tweets;
use function GuzzleHttp\Promise\exception_for;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class TweetsController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $this->middleware('auth');

        if(isset($request['q'])){
            $query=$request['q'];

            $search_results = Tweets::where('screen_name','LIKE','%'.$query.'%')
                ->orWhere('tweet_text','LIKE','%'.$query.'%')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            $search_results->appends(['q' => $query]);

            return view('tweets')->with('tweets', $search_results);
        }



        $tweets = Tweets::with('tweetmedia')
            ->sortable()

            ->orderBy('tweet_id', 'desc')
            ->limit(7)
            ->paginate(15);

        return view('tweets')->with('tweets', $tweets);

    }

    public function get()
    {
                header('Access-Control-Allow-Origin: *');

        $keys = Redis::keys('tweet:*');

        foreach($keys as $key){
            $media='';
            $created_at='';

            $tt= Redis::get($key);

            $tweet = json_decode($tt);




            if(isset($tweet->media))
                $media=$tweet->media;

            if(isset($tweet->timestamp))
                $created_at=$tweet->timestamp;

            if($tweet->is_approved)
                $tweets[] = array('tweet_id'=> $tweet->tweet_id,'tweetmedia'=> $media,'tweet_text'=>$tweet->tweet_text , 'screen_name' => $tweet->screen_name,'created_at'=>$created_at);
        }



        if(count($keys) > 0){
            if(isset($tweets))
                return json_encode($tweets);
        }


        $tweets = Tweets::with('tweetmedia')
            ->select('tweet_id', 'tweet_text', 'screen_name', 'created_at' )
            ->where('is_approved',true)
            ->orderBy('created_at', 'desc')
            ->limit(7)
            ->get();

        return json_encode($tweets);
    }

    public function posts()
    {
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = getenv('AW_APP_KEY').':'. getenv('AW_SECRET_TOKEN');
        $headers[] = 'AW_EVENTS_EVENT_ID:'. getenv('AW_EVENTS_EVENT_ID');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://appworks.opentext.com/appworks-conference-service/api/v2/feed/latest");

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $server_output = curl_exec ($ch);


        curl_close ($ch);
        $arr = json_decode($server_output, true);
       // dd(sizeof($arr['posts']));

        if(sizeof($arr['posts']) ==0 ){
            $url = './json/data.json'; // path to your JSON file
            $data = file_get_contents($url); // put the contents of the file into a variable
            $characters = $data;

            return $characters;
        }


        return json_encode($arr);

    }



    public function approveTweet($id){


        $redis = json_decode(Redis::get('tweet:'.$id));

        if($redis != null) {
            $redis->is_approved = true;
            Redis::del('tweet:' . $id);
            Redis::set('tweet:' . $id, json_encode($redis));

        }
        $tweet =   Tweets::find($id);
        $tweet->is_approved = true;
        $tweet->save();


        $data=array(
            'tweet_id'=> $tweet->tweet_id,
            'tweet_text' => $tweet->tweet_text,
            'user_id' => $tweet->user_id,
            'screen_name' => $tweet->screen_name,
            'name' => $tweet->name,
            'profile_image_url' => $tweet->profile_image_url,

            'is_approved'=>true,



        );

        if(isset($tweet->tweetmedia->media))
            $data['media']=$tweet->tweetmedia->media;



        Redis::set('tweet:' . $id, json_encode($data));

        return redirect()->back()->withFlashMessage('tweet approved');

    }


    public function rejectTweet($id){


        $redis = json_decode(Redis::get('tweet:' . $id));
        if($redis != null) {
            $redis->is_approved = false;
            Redis::del('tweet:' . $id);
            Redis::set('tweet:' . $id, json_encode($redis));
        }

        $tweet =   Tweets::find($id);
        $tweet->is_approved = false;
        $tweet->save();

        return redirect()->back()->withFlashMessage('tweet removed');
    }



}
