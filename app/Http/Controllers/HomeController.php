<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Post;
use Auth;
use DB;

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
        $posts_data = DB::table('posts')->join('users', 'user_id', '=', 'users.id')
                  ->select('users.*', 'posts.*')->orderBy('posts.created_at', 'desc')->get();
        return view('home')->with('posts_data',$posts_data);
    }
    public function profile($id)
    {
      $posts_data = DB::table('posts')->join('users', 'user_id', '=', 'users.id')
                ->select('users.*', 'posts.*')->where('user_id','=',$id)->orderBy('posts.created_at', 'desc')->get();
                // return $posts_data;
      return view('profile')->with(['posts_data'=>$posts_data]);
    }
}
