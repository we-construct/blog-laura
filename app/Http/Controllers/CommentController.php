<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        try {
            $auth_user = Auth::user();
            $comment = new Comment();
            $comment->comment = $request->comment;
            $comment->users()->associate($auth_user);

            if ($request->postId) {
                $post = Post::findOrFail($request->postId);
                $post->comments()->save($comment);
            } elseif ($request->userId) {
                $user = User::findOrFail($request->userId);
                $user->comments()->save($comment);
            } elseif ($request->imageId) {
                $image = PostImage::findOrFail($request->imageId);
                $image->comments()->save($comment);
            }

            return redirect()->back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $auth_user_id = Auth::id();
            $image = PostImage::findOrFail($id);
            $comments = Comment::with('users')
                ->where('commentable_id', $id)
                ->where('commentable_type', 'Image')
                ->get();
            return view('image-comments', [
                'image' => $image,
                'comments' => $comments,
                'auth_user_id' => $auth_user_id,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            return view('edit-comment', ['comment' => $comment]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }

    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'commentInput' => 'required',
            ]);
            $comment = Comment::findOrFail($id);
            $comment->update(['comment' => $request->commentInput]);

            switch ($comment->commentable_type) {
                case "Image":
                    return redirect('/comments/' . $comment->commentable_id);
                case "User":
                    return redirect('/profile/'. $comment->commentable_id . '/details');
                case "Post":
                    return redirect('/posts/' . $comment->commentable_id);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }
}
