@extends('main')

@section('title', '| Contact')

@section('content')

<div class="row">
  <div class="col-md-12">
    <h1>Contact Me <span class="glyphicon glyphicon-envelope"></span></h1>
    <hr>
    <form action="{{ url('contact') }}" method="POST">
      {{ csrf_field() }}

        <div class="form-group">
          <label name="email">Email:</label>
          <input id="email" name="email" class="form-control" id="email" placeholder="">
        </div>

        <div class="form-group">
          <label name="subject">Subject:</label>
          <input id="subject" name="subject" class="form-control" id="subject" placeholder="">
        </div>

        <div class="form-group">
          <label name="message">Message:</label>
          <textarea id="message" name="message" class="form-control" rows="8" cols="40">Type your message here...</textarea>
          <input type="submit" value="Send Message" class="btn btn-success">
        </div>
      </form>
    </div>
</div>

@endsection
