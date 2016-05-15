<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Validator;
use Auth;
use DB;
use App\Http\Requests;

class CommentsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [ 'comment' => 'required|max:100|regex:/^[(a-zA-Z\s)]+$/u']);
      if ($validator->fails()){
        return $validator->errors()->all();
      }
      $comment = new Comment;
      $comment->comment = $request->comment;
      $comment->post_id = $request->id;
      $comment->user_id = Auth::user()->id;
      $comment->save();
      return 1;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $post_comments = DB::table('comments')->join('users', 'user_id', '=', 'users.id')
                        ->select('users.*', 'comments.*')->where('post_id', '=', $id)->orderBy('comments.created_at', 'desc')->get();
      return $post_comments;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Comment::destroy($id);
      return redirect()->back();
    }
}
