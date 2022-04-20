<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Exception;
use Symfony\Component\Console\Input\Input;

class PostController extends Controller
{
    public function index()
    {
        try {
            $auth_user = Auth::user();
            $auth_user_followings_array = $auth_user->followers->pluck('id')->toArray();
            array_push($auth_user_followings_array, $auth_user->id);

            $posts = Post::with(['image' => function($query) {
                $query->where('main', '=', true);
            }])->whereIn('user_id', $auth_user_followings_array)
                ->orderBy('created_at', 'desc')
                ->paginate(3);

            return view('dashboard', [
                'posts' => $posts,
                'auth_user_id' => $auth_user->id
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }

    }

    public function create()
    {
        return view('blog');
    }

    public function store(PostRequest $request)
    {
        try {
            $post = Auth::user()->posts()->create([
                'title' => $request->post_title,
                'content' => $request->post_content,
            ]);
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $image_name = $image->getClientOriginalName();
                    $image->move(public_path('images/posts'), $image_name);
                    $post->image()->create([
                        'main' => array_search($image, $images) === 0,
                        'image_path' => $image_name,
                    ]);
                }
            }
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }

    }

    public function show($id)
    {
        try {
            $auth_user_id = Auth::id();
            $post_item = Post::findOrFail($id);
            $comments = $post_item->comments;
            $images = $post_item->image;

            return view('post-details', [
                'post_item' => $post_item,
                'comments' => $comments,
                'images' => $images,
                'auth_user_id' => $auth_user_id,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(500, $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $post_item = Post::findOrFail($id);
            if ($post_item->user_id === Auth::id()) {
                return view('post-item')->with('post_item', $post_item)
                    ->with('user_id', Auth::id());
            }
            return redirect('posts/'.$id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function update(PostRequest $request, $id)
    {
        try {
            Post::where('id', $id)
                ->update(['title' => $request->post_title, 'content' => $request->post_content]);

            return redirect('/dashboard');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $delete_post = Post::findOrFail($id);
            $delete_post->delete();
            return redirect('/dashboard');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function likeOrDislike($id) {
        try {
            $auth_user = Auth::user();
            if ($auth_user->liked_posts()->where('post_id', $id)->first() === null) {
                $auth_user->liked_posts()->attach($id);
            } else {
                $auth_user->liked_posts()->detach($id);
            }

            return redirect()->back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function likedPosts() {
        try {
            $auth_user = Auth::user();
            $posts = $auth_user->liked_posts()->paginate(3);

            return view('liked-posts', [
                'posts' => $posts,
                'user_id' => $auth_user->id
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function countryPosts($id) {
        try {
            $auth_user = Auth::user();
            $user = User::findOrFail($id);
            $posts = $user->country ? $user->country->posts()->paginate(3) : abort(500);

            return view('posts-country', [
                'posts' => $posts,
                'auth_user_id' => $auth_user->id,
                'country' => $user->country,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function searchUsers(Request $request) {
        try {
            if ($request->search_user !== null) {
                session(['search_text' => $request->search_user]);
            }
            $search_text = session('search_text');
            $pattern = '%' . $search_text . '%';
            $users = User::where('name', 'LIKE', $pattern)
                ->orWhere('email', 'LIKE', $pattern)
                ->paginate(3);
            $users_count = User::where('name', 'LIKE', $pattern)
                ->orWhere('email', 'LIKE', $pattern)
                ->count();
            $users->appends (array('search_text' => $search_text));
            $no_any_user = !$users->isEmpty();
            $posts_count = Post::where('content', 'LIKE', $pattern)
                ->orWhere('title', 'LIKE', $pattern)
                ->count();
            $comments_count = Comment::where('comment', 'LIKE', $pattern)->count();

            return view('search-users', [
                'search_text' => $search_text,
                'users' => $users,
                'auth_user' => Auth::user(),
                'no_any_user' => $no_any_user,
                'posts_count' => $posts_count,
                'comments_count' => $comments_count,
                'users_count' => $users_count,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function searchPosts(Request $request) {
        try {
            $search_text = session('search_text');
            $pattern = '%' . $search_text . '%';
            $posts = Post::where('content', 'LIKE', $pattern)
                ->orWhere('title', 'LIKE', $pattern)
                ->paginate(3);
            $posts_count = Post::where('content', 'LIKE', $pattern)
                ->orWhere('title', 'LIKE', $pattern)
                ->count();
            $posts->appends (array('search_text' => $search_text));
            $no_any_post = !$posts->isEmpty();
            $users_count = User::where('name', 'LIKE', $pattern)
                ->orWhere('email', 'LIKE', $pattern)
                ->count();
            $comments_count = Comment::where('comment', 'LIKE', $pattern)->count();

            return view('search-posts', [
                'search_text' => $search_text,
                'posts' => $posts,
                'user_id' => Auth::id(),
                'no_any_post' => $no_any_post,
                'users_count' => $users_count,
                'comments_count' => $comments_count,
                'posts_count' => $posts_count,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function searchComments(Request $request) {
        try {
            $search_text = session('search_text');
            $pattern = '%' . $search_text . '%';
            $comments = Comment::where('comment', 'LIKE', $pattern)->paginate(3);
            $comments_count = Comment::where('comment', 'LIKE', $pattern)->count();
            $no_any_comment = !$comments->isEmpty();
            $posts_count = Post::where('content', 'LIKE', $pattern)
                ->orWhere('title', 'LIKE', $pattern)
                ->count();
            $users_count = User::where('name', 'LIKE', $pattern)
                ->orWhere('email', 'LIKE', $pattern)
                ->count();

            return view('search-comments', [
                'search_text' => $search_text,
                'comments' => $comments,
                'no_any_comment' => $no_any_comment,
                'users_count' => $users_count,
                'posts_count' => $posts_count,
                'comments_count' => $comments_count,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }
}
