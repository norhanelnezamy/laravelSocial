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
                    @if ($errors->has('post'))
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
              <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="panel-heading">
                    <ul class="nav nav-pills" >
                      <li role="presentation"><img src="/{{$PD->profile_pic}}" style="width:35px;height:35px;"></li>
                      <li role="presentation"><a href="/profile/{{$PD->user_id}}">{{ $PD->name }}</a></li>
                      <li role="presentation" style="margin-top:10px;"> posted new post at: {{$PD->created_at}}</li>
                      <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                              <li><a href="/post/delete/{{$PD->id}}"><i class="fa fa-btn fa-sign-out"></i>Delete</a></li>
                          </ul>
                      </li>
                  </ul>
                  </div>
                  <p style="margin-left:10px;">{{ $PD->post }}</p>
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
                    <div id="div_{{$PD->id}}" name="div_{{$PD->id}}">
                             {{-- @if($PD->user_id == Auth::user()->id)
                               <li role="presentation"><a href="/comment/delete/{{$comment->id}}">X</a></li>
                             @endif --}}
                   </div>
                  </div>
              </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
