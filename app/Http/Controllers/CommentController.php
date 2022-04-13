<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CommentRequest $request)
    {
        $auth_user = Auth::user();
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->users()->associate($auth_user);

        if ($request->postId) {
            $post = Post::find($request->postId);
            $post->comments()->save($comment);
        } elseif ($request->userId) {
            $user = User::find($request->userId);
            $user->comments()->save($comment);
        } elseif ($request->imageId) {
            $image = PostImage::find($request->imageId);
            $image->comments()->save($comment);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $auth_userId = Auth::id();
        $image = PostImage::find($id);
        $comments = Comment::with('users')
            ->where('commentable_id', $id)
            ->where('commentable_type', 'Image')
            ->get();
        return view('image_comments', ['image' => $image, 'comments' => $comments, 'auth_userId' => $auth_userId]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::find($id);
        return view('edit_comment', ['comment' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'commentInput' => 'required',
        ]);
        $comment = Comment::find($id);
        $comment->update(['comment' => $request->commentInput]);
        switch ($comment->commentable_type) {
            case "Image":
                return redirect('/comments/' . $comment->commentable_id);
                break;
            case "User":
                return redirect('/profile/'. $comment->commentable_id . '/details');
                break;
            case "Post":
                return redirect('/posts/' . $comment->commentable_id);
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $comment = Comment::find($id);
            $comment->delete();
            return redirect()->back();
        } catch(\Exception $e) {
            return back()->withError($e->getMessage());
        }

    }
}
