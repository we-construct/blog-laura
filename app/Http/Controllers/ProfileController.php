<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Country;
use App\Models\Follower;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function index()
    {
        try {
            $auth_user = Auth::user();
            $followers = $auth_user->followers->count();
            $following = $auth_user->following->count();
            $posts = $auth_user->posts()->paginate(3);

            return view('profile', [
                'auth_user' => $auth_user,
                'followers' => $followers,
                'followings' => $following,
                'posts' => $posts,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }

    }

    public function show($id)
    {
        try {
            $auth_user_id = Auth::id();
            $user = User::findOrFail($id);
            $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->paginate(3);
            $comments = $user->comments;

            return view('user-profile-details', [
                'user' => $user,
                'posts' => $posts,
                'comments' => $comments,
                'auth_user_id' => $auth_user_id,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function edit()
    {
        try {
            $countries = Country::all();

            return view('edit_profile', [
                'user' => Auth::user(),
                'countries' => $countries,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }

    }

    public function update(ProfileRequest $request, $id)
    {
        try {
            $auth_user = Auth::user();
            $country = Country::findOrFail($request->country);
            $auth_user->country()->associate($country);
            $auth_user->update(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password)]);

            return redirect('/profile');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }

    }

    public function updateAvatar(Request $request, $id) {
        $request->validate([
            'avatar' => 'required|image',
        ]);
        try {
            if ($request->hasFile('avatar')) {
                $user = User::findOrFail($id);
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
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function allUsers() {
        try {
            $auth_user = Auth::user();
            $users = User::where('id', '<>', $auth_user->id)->paginate(3);

            return view('users-list', [
                'users' => $users,
                'auth_user' => $auth_user,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }

    }

    public function followOrUnfollow(Request $request, $id) {
        try {
            $auth_user = Auth::user();
            $user_to_follow_or_unfollow = User::where('id', $id)->first();
            $check_following_existence = $auth_user->followers()->where('following', '=' , $id)->first();

            if ($check_following_existence === null) {
                $auth_user->followers()->attach($user_to_follow_or_unfollow->id);
            } else {
                $auth_user->followers()->detach($user_to_follow_or_unfollow->id);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function displayFollowers() {
        try {
            $auth_user = Auth::user();
            $following_users = $auth_user->following()->paginate(3);

            return view('followers', [
                'auth_user' => $auth_user,
                'following_users' => $following_users,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function displayFollowings() {
        try {
            $auth_user = Auth::user();
            $followed_users = $auth_user->followers()->paginate(3);

            return view('followings', [
                'auth_user' => $auth_user,
                'followed_users' => $followed_users,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function initialPage() {
        if (Auth::user()) {
            return redirect('/dashboard');
        }
        $posts = Post::paginate(3);

        return view('welcome', ['posts' => $posts]);
    }
}

