<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $auth_user = Auth::user();
        $auth_user_followings_array = $auth_user->followers->pluck('id')->toArray();
        array_push($auth_user_followings_array, $auth_user->id);

        $posts = Post::whereIn('user_id', $auth_user_followings_array)->orderBy('created_at', 'desc')->paginate(3);
        $liked_posts = $auth_user->liked_posts->pluck('id')->toArray();

        return view('dashboard', ['posts' => $posts, 'userId' => $auth_user->id, 'liked_posts' => $liked_posts,]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostRequest $request)
    {
        Auth::user()->posts()->create([
            'title' => $request->post_title,
            'content' => $request->post_content,
        ]);
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $postItem = Post::find($id);
        return view('post_details')->with('postItem', $postItem);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $postItem = Post::find($id);
        if ($postItem->user_id === Auth::id()) {
            return view('post_item')->with('postItem', $postItem)
                ->with('user_id', Auth::id());
        }
        else {
            return redirect('posts/'.$id);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostRequest $request, $id)
    {
            Post::where('id', $id)
                ->update(['title' => $request->post_title, 'content' => $request->post_content]);
            return redirect('/dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $deletePost = Post::find($id);
        $deletePost->delete();
        return redirect('/dashboard');
    }

    public function myPosts($userId) {
        $posts = Post::where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(3);
        return view('my_posts')->with('posts', $posts);
    }

    public function allPosts() {
        $posts = Post::paginate(3);
        return view('all_posts', ['posts' => $posts]);
    }

    public function likeOrDislike($id) {
        $auth_user = Auth::user();

        if ($auth_user->liked_posts()->where('post_id', $id)->first() === null) {
            $auth_user->liked_posts()->attach($id);
        } else {
            $auth_user->liked_posts()->detach($id);
        }
        return redirect()->back();
    }

    public function likedPosts() {
        $auth_user = Auth::user();
        $posts = $auth_user->liked_posts()->paginate(3);
        $liked_posts = $auth_user->liked_posts->pluck('id')->toArray();

        return view('liked_posts', ['posts' => $posts, 'userId' => $auth_user->id, 'liked_posts' => $liked_posts]);
    }
}
