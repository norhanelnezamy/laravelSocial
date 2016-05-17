<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Validator;
use Auth;
use DB;
use App\Http\Requests;
use App\Post;

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
      $post = Post::find($id);
      if ($post) {
        $users_comments = DB::table('comments')->join('users', 'user_id', '=', 'users.id')
                          ->select('users.*', 'comments.*')->where('post_id', '=', $id)->orderBy('comments.created_at', 'desc')->get();
          foreach ($users_comments as $UC) {
            if ($UC->user_id == Auth::user()->id) {
              $data[$UC->id] = "<ul id='ul_comment_".$UC->id."' class='nav nav-pills' >"
                               ."<li><img src='".$UC->profile_pic."'style='width:35px;height:35px;'></li>"
                               ."<li><a href='/profile/".$UC->user_id."'>".$UC->name."</a></li>"
                               ."<li style='margin-top:10px;'>".$UC->created_at."</li>"
                               ."<li style='margin-top:10px;'id='li_comment_".$UC->id."' >".$UC->comment."</li>"
                               ."<li style='margin-top:5px;'><input type='button' name='editComment' id='".$UC->id
                               ."'data-toggle='modal' data-target='#editCommentModel' value='Edit' class='btn btn-link' style='text-decoration:none;'></li>"
                               ."<li style='margin-top:5px;'><input type='button' name='deleteComment' id='".$UC->id
                               ."' value='X' class='btn btn-link' style='text-decoration:none;'></li></ul>";
            }
            elseif ($post->user_id == Auth::user()->id) {
              $data[$UC->id] = "<ul id='ul_comment_".$UC->id."' class='nav nav-pills' >"
                               ."<li><img src='".$UC->profile_pic."'style='width:35px;height:35px;'></li>"
                               ."<li><a href='/profile/".$UC->user_id."'>".$UC->name."</a></li>"
                               ."<li style='margin-top:10px;'>".$UC->created_at."</li>"
                               ."<li style='margin-top:10px;'>".$UC->comment."</li>"
                               ."<li style='margin-top:5px;'><input type='button' name='deleteComment' id='".$UC->id
                               ."' value='X' class='btn btn-link' style='text-decoration:none;'></li></ul>";
            }
//
            else {
                $data[$UC->id] = "<ul id='ul_comment_".$UC->id."' class='nav nav-pills' >"
                                 ."<li><img src='".$UC->profile_pic."'style='width:35px;height:35px;'></li>"
                                 ."<li><a href='/profile/".$UC->user_id."'>".$UC->name."</a></li>"
                                 ."<li style='margin-top:10px;'>".$UC->created_at."</li>"
                                 ."<li style='margin-top:10px;'>".$UC->comment."</li></ul>";
            }
        }
        return $data;
      }
      return NULL;
    }

    public function update(Request $request, $id)
    {
      $validator = Validator::make($request->all(), ['edit_comment' => 'required|regex:/^[(a-zA-Z\s)]+$/u']);
      if ($validator->fails()){
         return $validator->errors()->all();
      }
      $comment = Comment::find($id);
      if ($comment) {
        $comment->comment = $request->edit_comment;
        $comment->save();
        return 1;
      }
      return "not found...!";
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $comment = Comment::find($id);
      if ($comment) {
        Comment::destroy($id);
        return 1;
      }
      return 0;
    }
}
