@extends('main')

@section('title', '| Home')

@section('content')
  <div class="row">
          <div class="col-md-12">
             <div class="jumbotron">
             <h1>Welcome to My Blog <span class="glyphicon glyphicon-globe" style="margin-right: 15px; margin-bottom:15px;"></span></h1>
             <p class="lead">This is my first blog site built with Laravel. Hope you like it! Please read my popular post!</p>
             <p><a class="btn btn-primary btn-lg" href="{{ url('blog') }}" role="button">Popular Post</a></p>
             </div>
          </div>
  </div> <!-- end of header .row -->

<div class="row">
    <div class="col-md-8">

      @foreach($posts as $post)

         <div class="post">
            <h3>{{ $post->title }}</h3>
            <p>{{ substr(strip_tags($post->body), 0, 300) }}{{ strlen($post->body) > 300 ? "..." : "" }}</p>
            <a href="{{ url('blog/'.$post->slug) }}" class="btn btn-primary">Read More</a>
          </div>

            <hr>
            @endforeach
      </div>

          <div class="col-md-3 col-md-offset-1">
              <h2>Sidebar</h2>
          </div>

</div>
@endsection
