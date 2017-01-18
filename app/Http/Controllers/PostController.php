<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use Session;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = Post::orderBy('id', 'desc')->paginate(10); // create a variable and store all the blog posts in it from the database
        return view('posts.index')->with('posts', $posts); // return a view and pass in the above variable

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('posts.create');  //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data
        $this->validate($request, array(
          'title' => 'required|max:255',
          'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
          'body' => 'required'
        ));

        // store in the database
        $post = new Post;

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->body = $request->body;

        $post->save();

        // redirect to another page
        Session::flash('success','The blog post was successfully save!');

        return redirect()->route('posts.show', $post->id);


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
       return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $post = Post::find($id);  // Find the post in the database and save as a var
      return view('posts.edit')->with('post', $post);  // Return the view and pass in the var
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
        // Validate the data
        $post = Post::find($id);

        if ($request->input('slug') == $post->slug) {
          $this->validate($request, array(
            'title' => 'required|max:255',
            'body' => 'required'
          ));
        } else {
        $this->validate($request, array(
          'title' => 'required|max:255',
          'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
          'body' => 'required'
        ));
      }

        // Save the data to the database
        $post = Post::find($id);

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->body = $request->input('body');

        $post->save();


        // Set flash data with success message
        Session::flash('success', 'This post was successfully saved.');

        // Redirect with flash data to posts.show
        return redirect()->route('posts.show', $post->id);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);

        $post->delete();

        Session::flash('success', 'The post was successfully deleted.');
        return redirect()->route('posts.index');
    }
}
