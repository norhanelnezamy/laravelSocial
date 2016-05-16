<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Post;
use Auth;
class PostsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), ['post' => 'required|regex:/^[(a-zA-Z\s)]+$/u']);
      if ($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();
      }
      $post = new Post;
      $post->post = $request->post;
      $post->user_id = Auth::user()->id;
      $post->save();
      return redirect()->back();
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
      $validator = Validator::make($request->all(), ['edit_post' => 'required|regex:/^[(a-zA-Z\s)]+$/u']);
      if ($validator->fails()){
         return $validator->errors()->all();
      }
      $post = Post::find($id);
      if ($post) {
        $post->post = $request->edit_post;
        $post->user_id = Auth::user()->id;
        $post->save();
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
        $post = Post::find($id);
        if ($post) {
          Post::destroy($id);
          return 1;
        }
        return 0;
    }
}
