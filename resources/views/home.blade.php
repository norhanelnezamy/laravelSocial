@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading">Add New Post To Timeline</div>
                <div class="panel-body">
                  <form class="form-horizontal" style="padding:0" role="form" method="POST" action="{{ url('/post/create') }}">
                      {!! csrf_field() !!}
                    <textarea class="form-control" rows="5" name="post" placeholder="write new post....."></textarea>
                    @if($errors->has('post'))
                      <div class="alert alert-danger">
                          <ul>
                            @foreach($errors->get('post') as $er)
                                <li>{{$er}}</li>
                            @endforeach
                          </ul>
                      </div>
                   @endif
                      <button type="submit" style="margin:1%;" class="btn btn-primary">Post</button>
                </form>
              </div>
            </div>

            @foreach($posts_data as $PD)
              <div class="panel panel-default" id="post_id_{{$PD->id}}">
                  <div class="panel-body">
                    <div class="panel-heading">
                    <ul class="nav nav-pills" >
                      <li role="presentation"><img src="{{$PD->profile_pic}}" style="width:35px;height:35px;"></li>
                      <li role="presentation"><a href="/profile/{{$PD->user_id}}">{{ $PD->name}}</a></li>
                      <li role="presentation" style="margin-top:10px;"> posted new post at: {{$PD->created_at}}</li>
                      @if($PD->user_id == Auth::user()->id )
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                              <li role="presentation"><input type="button" id="{{$PD->id}}" name="edit_post"  value="edit" class="btn btn-link"  data-toggle="modal" data-target="#myModal_{{$PD->id}}" style="text-decoration:none;"/></li>
                              <li role="presentation"><input type="button" id="{{$PD->id}}" name="delete_post"  value="delete" class="btn btn-link"style="text-decoration:none;"/></li>
                            </ul>
                        </li>
                        <div class="modal fade" id="myModal_{{$PD->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_{{$PD->id}}"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Edit Post</h4>
                              </div>
                              <div class="modal-body">
                                <textarea rows="3" cols="60" id="edit_post_{{$PD->id}}" name="edit_post">{{ $PD->post }}</textarea>
                                <div id="model_error_{{$PD->id}}" style="width:91%;"></div>
                              </div>
                              <div class="modal-footer">
                                <input type="button" class="btn btn-primary" id="{{$PD->id}}" name="edit_post_model" value="Save changes">
                              </div>
                            </div>
                          </div>
                        </div>
                      @endif
                    </ul>
                  </div>
                  <p style="margin-left:10px;" id="post_body_{{$PD->id}}">{{ $PD->post }}</p>
                  <form class="form-horizontal" role="form" method="POST" name="comment_form">
                      {!! csrf_field() !!}
                      <meta name="csrf-token" content="{{ csrf_token() }}">
                      <input type="hidden" name="post_id" value="{{$PD->id}}">
                      <ul class="nav nav-pills" >
                        <li role="presentation"><textarea rows="1" cols="60" id="comment_{{$PD->id}}"  placeholder="write a comment maximum 100 charachter....."></textarea></li>
                        <li role="presentation"><input type="button" id="{{$PD->id}}"  name="addComment"  value="Add" class="btn btn-link"style="text-decoration:none;"/></li>
                        <li role="presentation"><input type="button" id="{{$PD->id}}"  name="showComment" value="show comments"class="btn btn-link show_{{$PD->id}}"style="text-decoration:none;"></li>
                      </ul>
                  </form>
                 <div id="comment_error_{{$PD->id}}" style="width:72%;"></div>
                 <div id="div_{{$PD->id}}" name="div_{{$PD->id}}"></div>
                </div>
              </div>
            @endforeach
            <div class="modal fade" id="editCommentModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit comment</h4>
                  </div>
                  <div class="modal-body">
                    <textarea rows="1" cols="60" id="edit_comment" name="edit_comment"></textarea>
                    <div id="model_error" style="width:91%;"></div>
                  </div>
                  <div class="modal-footer">
                    <input type="button" class="btn btn-primary" name="edit_comment_model" value="Save changes">
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
