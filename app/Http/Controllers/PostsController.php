<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(5);

        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body'  => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        if($request ->hasFile('cover_image')){
            //Get filename with the extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
           //Get just filename
           $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
           //get Extension
           $extension = $request->file('cover_image')->getClientOriginalExtension();
           //Create filename to store : it will call the file name and extend it with timestamp to be unique
           $fileNameToStore = $fileName.'_'.time().'.'.$extension;
           //finally upload image
           $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
          }else{
              $fileNameToStore ='noimage.jpeg';
          }

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Post::find($id);
        return view('posts.show')->with('posts', $posts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posts = Post::find($id);
        if(auth()->user()->id !== $posts->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }
        return view('posts.edit')->with('posts', $posts);
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
        $this->validate($request, [
            'title' => 'required',
            'body'  => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        if($request ->hasFile('cover_image')){
            //Get filename with the extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
           //Get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
           //get Extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
           //Create filename to store : it will call the file name and extend it with timestamp to be unique
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
           //finally upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
          }

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $fileNameToStore;
        }

        $post->save();

        return redirect('/posts')->with('success', 'Post Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Post::find($id);
        $posts = Post::find($id);
        if(auth()->user()->id !== $posts->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }
        $posts->delete();

        return redirect('/posts')->with('success', 'Post Removed!');
    }
}
