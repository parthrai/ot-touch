<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Mail\TokenEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
	
    public function index()
    {
      $users = User::all();
      return view('users')->with('users', $users);
    }

    public function createUserToken()
    {
      $user = \Auth::user();
      $token = $user->createToken($user->email, [])->accessToken;
        Mail::to($user->email)->send(new TokenEmail($token));
    }

    public function giveUserAdminPermissions(Request $request)
    {//dd($id);
		$id = $request['id'];
    	$user = User::find($id);
    	$user->is_admin = True;
    	$user->save();

    	return back()->with(['flash_success' => 'You have successfully updated the users admin access']);
    }

    /**
     * Remove admin access for a user
     * 
     */
    public function removeUserAdminPermissions(Request $request)
    {
		$id = $request['id'];
    	$user = User::find($id);

    	if( $user->id == \Auth::user()->id )
    	{
    		return back()->with(['flash_error' => 'You cant update your own admin access silly']);
    	}

    	$user->is_admin = False;
    	$user->save();

    	return back()->with(['flash_success' => 'You have successfully Removed this users admin access']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //creating a new user
      if($request->isMethod('post')){
			//add user to database and send successful flash message
        $user = new User;
        $user->name =  $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return back()->with(['flash_success' => 'New Users Added']);
      }
		else {
			
	      return view('newuser');
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function delete($id, Request $request)
    {

        $users = User::find($id);

         if (!$users){

             return 'We cannot locate this record to delete';
         }
            $users->delete();


        return back()->with(['flash_success' => 'User Deleted']);
    }

}
