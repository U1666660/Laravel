@extends('main')

@section('title', '| Contact')

@section('content')
<div class="row">
  <div class="col-md-12">
    <h1>Contact Me</h1>
    <hr>
    <form class="" action="index.html" method="post">
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" id="email" placeholder="">
        </div>

        <div class="form-group">
          <label for="subject">Subject:</label>
          <input type="subject" class="form-control" id="subject" placeholder="">
        </div>

        <div class="form-group">
          <label for="message">Message:</label>
          <textarea name="name" class="form-control" rows="8" cols="40">Type your message here...</textarea>
          <input type="button" name="submit" value="Send Message" class="btn btn-success">
        </div>
      </form>
    </div>
</div>
@endsection
