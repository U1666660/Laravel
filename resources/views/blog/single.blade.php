@extends('main')
<?php $titleTag = htmlspecialchars($post->title); ?>
@section('title', "| $titleTag")

@section('content')

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
      
        <h1>{{ $post->title }}</h1>
        <p>{!! $post->body !!}</p>
        <hr>
        <p>Posted In: {{ $post->category->name }}</p>
      </div>
    </div>

    <div class="row">
  		<div class="col-md-8 col-md-offset-2">
        <h3 class="comments-title" style="margin-bottom: 45px; margin-right: 15px;"><span class="glyphicon glyphicon-comment" style="margin-right: 15px;"></span>
          {{ $post->comments()->count() }} Comments</h3>
  			@foreach($post->comments as $comment)
  				<div class="comment" style="margin-bottom: 45px;">

            <div class="author-info">
                <img src="{{ "https://www.gravatar.com/avatar/" . md5( strtolower( trim($comment->email))) . "?s=50&d=wavatar" }}" class="author-image" style="width: 50px; height: 50px; border-radius: 50%; float: left;"/>
              <div class="author-name" style="float:left; margin-left: 15px; margin: 5px 0px;">

                  <h4>{{ $comment->name }}</h4>


              <p class="created_at" style="font-size: 11px; font-style: italic; color: #aaa;">{{ date('M j, Y H:i', strtotime($comment->created_at)) }}</p>


              </div>
  					</div>

            <div class="comment-content" style="clear: both; margin-left: 80px; font-size: 16px; line-height: 1.3em;">
              {{ $comment->comment }}
            </div>

  				</div>
  			@endforeach
  		</div>
  	</div>

  	<div class="row">
  		<div id="comment-form" class="col-md-8 col-md-offset-2" style="margin-top: 50px;">
  			{{ Form::open(['route' => ['comments.store', $post->id], 'method' => 'POST']) }}

  				<div class="row">
  					<div class="col-md-6">
  						{{ Form::label('name', "Name:") }}
  						{{ Form::text('name', null, ['class' => 'form-control']) }}
  					</div>

  					<div class="col-md-6">
  						{{ Form::label('email', 'Email:') }}
  						{{ Form::text('email', null, ['class' => 'form-control']) }}
  					</div>

  					<div class="col-md-12">
  						{{ Form::label('comment', "Comment:") }}
  						{{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5']) }}

  						{{ Form::submit('Add Comment', ['class' => 'btn btn-success btn-block', 'style' => 'margin-top:15px;']) }}
  					</div>
  				</div>

  			{{ Form::close() }}
  		</div>
  </div>

@endsection
