<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use App\Category;
use Session;
use Purifier;
use Image;
use Storage;

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

      $categories = Category::all();
      $tags = Tag::all();
      return view('posts.create')->with('categories', $categories)->with('tags', $tags);  //
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
          'title'       => 'required|max:255',
          'slug'        => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
          'category_id' => 'required|integer',
          'body'        => 'required'

        ));

        // store in the database
        $post = new Post;

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->body = Purifier::clean($request->body);

          // save the image
          if ($request->hasFile('featured_img')) {

            $image = $request->file('featured_img');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);

            Image::make($image)->resize(800, 400)->save($location);
            $post->image = $filename;
          }

        $post->save();

        $post->tags()->sync($request->tags, false);



        // redirect to another page
        Session::flash('success','The blog post was successfully saved.');

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
      $categories = Category::all();
      $cats = array();
      foreach ($categories as $category) {
        $cats[$category->id] = $category->name;
      }

      $tags = Tag::all();
      $tags2 = array();
      foreach ($tags as $tag) {
        $tags2[$tag->id] = $tag->name;
      }

      return view('posts.edit')->with('post', $post)->with('categories', $cats)->with('tags', $tags2);  // Return the view and pass in the var
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


        $this->validate($request, array(
          'title' => 'required|max:255',
          'slug' => "required|alpha_dash|min:5|max:255|unique:posts,slug,$id",
          'category_id' => 'required|integer',
          'body' => 'required',
          'featured_img' => 'image'
        ));


        // Save the data to the database
        $post = Post::find($id);

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->category_id = $request->input('category_id');
        $post->body = Purifier::clean($request->input('body'));

        if ($request->hasFile('featured_img')) {
          // add the new image

          $image = $request->file('featured_img');
          $filename = time() . '.' . $image->getClientOriginalExtension();
          $location = public_path('images/' . $filename);

          Image::make($image)->resize(800, 400)->save($location);
          $oldFilename = $post->image;
          // update to database
          $post->image = $filename;
          // delete the old image
          Storage::delete($oldFilename);
        }


        $post->save();

        if (isset($request->tags)) {
            $post->tags()->sync($request->tags);
          } else {
            $post->tags()->sync(array());
          }



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
        $post->tags()->detach();
        Storage::delete($post->image);


        $post->delete();

        Session::flash('success', 'The post was successfully deleted.');
        return redirect()->route('posts.index');
    }
}
