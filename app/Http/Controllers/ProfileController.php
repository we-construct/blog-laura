<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Follower;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $users = User::with('followers', 'following')
            ->where('id', '<>', Auth::id())
            ->paginate(2);
        return view('profile', [
            'auth_user' => Auth::user(),
            'following_ids' => Auth::user()->following_ids,
            'users' => $users,
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->paginate(3);
        return view('user_profile_details', ['user' => $user, 'posts' => $posts]);
    }

    public function edit($id)
    {
        return view('edit_profile', ['user' => Auth::user()]);
    }

    public function update(ProfileRequest $request, $id)
    {
        User::where('id', $id)
            ->update(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password)]);
        return redirect('/profile');
    }

    public function updateAvatar(Request $request, $id) {
        $request->validate([
            'avatar' => 'required|image',
        ]);
        if ($request->hasFile('avatar')) {
            $user = User::find($id);
            if ($user->avatar_path !== "") {
                unlink(public_path('images/avatar/'.$user->avatar_path));
            }
            $avatar = $request->file('avatar');
            $avatar_name = $avatar->getClientOriginalName();
            $avatar->move(public_path('images/avatar'), $avatar_name);
            User::where('id', $id)
                ->update(['avatar_path' => $avatar_name]);
            return redirect('/profile');
        }
    }

    public function allUsers() {
        $users = User::with('followers', 'following')->where('id', '<>', Auth::id())->paginate(3);
        return view('users_list', [
            'users' => $users,
            'following_ids' => Auth::user()->following_ids,
            'auth_user_id' => Auth::id(),
        ]);
    }

    public function followOrUnfollow($id) {

        $follower_and_followed_user = Auth::user()->followers()->where('following', '=' , $id)->first();

        if ($follower_and_followed_user === null) {
            $auth_user = User::find(Auth::id());
            $auth_user->followers()->create(["following" => $id]);
        } else {
            $follower_and_followed_user->delete();
        }
        return redirect()->back();
    }
}

