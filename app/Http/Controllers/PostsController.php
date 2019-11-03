<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use App\Post;
use App\Like;
use DB;
// use Auth;

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
        // $posts = Post::all();
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index')->with('posts', $posts);
    }

    // public function likePost(Request $request) {
    //     $post_id = $request['postId'];
    //     $is_like = $request['isLike'] === 'true';
    //     $update = false;
    //     $post = Post::find($post_id);

    //     if(!$post) {
    //         return null;
    //     }


    //     $user = Auth::user();
    //     $like = $user->likes()->where('post_id', $post_id)->first();
    //     if($like) {
    //         $already_like = $like->like;
    //         $update = true;
    //         if($already_like == $is_like) {
    //             $like->delete();
    //             return null;
    //         }
    //     } else {
    //         $like = new Like();
    //     }

    //     $like->like = $is_like;
    //     $like->user_id = $user->id;
    //     $like->post_id = $post->id;

    //     if($update) {
    //         $like->update();
    //     } else {
    //         $like->save();
    //     }

    //     return null;
    // }

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
                'body' => 'required',
                'cover_image' => 'image|nullable|max:1999'
        ]);

        // Handle file upload
        if($request->hasFile('cover_image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload the image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        //Create a post
        $post = new Post;
       
       
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = Auth::user()->id;
        $post->admin_id = $request->input('admin_id');
        $post->cover_image = $fileNameToStore;
        $post->save();
        

        return redirect('/posts')->with('success', 'Post Created');
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
        $post = Post::find($id);

        //Check for correct user
        if(auth()->user()->id !==$post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized page');
        }

        return view('posts.edit')->with('post', $post);
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
            'body' => 'required'
    ]);

    // Handle file upload
    if($request->hasFile('cover_image')) {
        // Get filename with the extension
        $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
        
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        // Get just ext
        $extension = $request->file('cover_image')->getClientOriginalExtension();
        //Filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        //Upload the image
        $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
    }

    //Create a post
    $post = Post::find($id);
    $post->title = $request->input('title');
    $post->body = $request->input('body');
    if($request->hasFile('cover_image')) {
        $post->cover_image = $fileNameToStore;
    }
    $post->save();

    return redirect('/posts')->with('success', 'Post Updated');
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
        
        //Check for correct user
        if(auth()->user()->id !==$post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized page');
        }

        if($post->cover_image != 'noimage.jpg') {
            // Delete the image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();

        return redirect('/posts')->with('success', 'Post Deleted');
    }

    public function search(Request $request) {
        $search = $request->get('search');
        $posts = DB::table('posts')->where('title', 'like', '%'.$search.'%')->get();
        // return view('index', ['posts' => $posts]);
        return view('posts.index', compact('posts'));
    }

    public function usersPost(Request $request) {
        $posts = DB::table('posts')->where('user_id', auth()->id())->get();
        return redirect('/posts');
    }
}
