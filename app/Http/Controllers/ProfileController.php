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
        $auth_user = Auth::user();
        $followers = $auth_user->followers()->get();
        $following = $auth_user->following()->get();
        $posts = $auth_user->posts()->paginate(3);

        return view('profile', [
            'auth_user' => $auth_user,
            'followers' => $followers,
            'followings' => $following,
            'posts' => $posts,
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
        $auth_user = Auth::user();

        return view('users_list', [
            'users' => $users,
            'auth_user' => $auth_user,
        ]);
    }

    public function followOrUnfollow($id) {
        $auth_user = Auth::user();
        $user_to_follow_or_unfollow = User::where('id', $id)->first();
        $check_following_existence = Auth::user()->followers()->where('following', '=' , $id)->first();

        if ($check_following_existence === null) {
            $auth_user->followers()->attach($user_to_follow_or_unfollow->id);
        } else {
            $auth_user->followers()->detach($user_to_follow_or_unfollow->id);
        }
        return redirect()->back();
    }

    public function displayFollowers() {
        $auth_user = Auth::user();
        $following_users = $auth_user->following()->paginate(3);
        return view('followers', [
            'auth_user' => $auth_user,
            'following_users' => $following_users,
            ]);
    }

    public function displayFollowings() {
        $auth_user = Auth::user();
        $followed_users = $auth_user->followers()->paginate(3);
        return view('followings', [
            'auth_user' => $auth_user,
            'followed_users' => $followed_users,
        ]);
    }

    public function initialPage() {
        if (Auth::user()) {
            return redirect('/dashboard');
        }
        return view('welcome');
    }
}

