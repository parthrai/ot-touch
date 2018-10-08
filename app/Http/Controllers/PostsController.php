<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    //

    public function storePosts()
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

       // dd($arr['posts'][0]);


        for($i=0 ; $i < count($arr['posts']) ; $i++){

          $checkForPosts= Post::where('dataId',$arr['posts'][$i]['id']['dataId'])->count();




            if($checkForPosts == 0) {
                $data = array(
                    'dataId' => $arr['posts'][$i]['id']['dataId'],
                    'eventId' => $arr['posts'][$i]['id']['eventId'],
                    'uuid' => $arr['posts'][$i]['attendee']['uuid'],


                    'email' => $arr['posts'][$i]['attendee']['email'],
                    'firstName' => $arr['posts'][$i]['attendee']['firstName'],
                    'lastName' => $arr['posts'][$i]['attendee']['lastName'],
                    'title' => $arr['posts'][$i]['attendee']['title'],
                    'company' => $arr['posts'][$i]['attendee']['company'],
                    'content' => $arr['posts'][$i]['content'],
                    'teamId' => $arr['posts'][$i]['teamId'],
                    'created' => $arr['posts'][$i]['created'],
                    'updated' => $arr['posts'][$i]['updated'],

                );


                Post::create($data);

            }
        }



        return "done!";



       // return json_encode($arr);

    }


    public function index(){

        return Post::all();
    }


    public function get($id){

        return Post::find($id);
    }
}
