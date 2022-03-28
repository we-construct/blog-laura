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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('followers', 'following')
            ->where('id', '<>', Auth::id())
            ->paginate(2);
        return view('profile', [
            'auth_user' => Auth::user(),
            'following_ids' => Auth::user()->following_ids,
            'auth_user_id' => Auth::id(),
            'users' => $users,
            ]);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
//        $posts = $user->posts->paginate(3);
        $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->paginate(3);
        return view('user_profile_details', ['user' => $user, 'posts' => $posts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('edit_profile', ['user' => Auth::user()]);
    }

    public function update(ProfileRequest $request, $id)
    {
        $user = User::find($id);
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatar_name = $avatar->getClientOriginalName();
            $avatar->move(public_path('images'), $avatar_name);
            User::where('id', $id)
                ->update(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password), 'avatar_path' => $avatarName]);
            return redirect('/profile');
        }
        User::where('id', $id)
            ->update(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password)]);
        return redirect('/profile');
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

        $follower_and_followed_user = Follower::where('user_id', Auth::id())
                                            ->where('following', $id)
                                            ->first();
        if ($follower_and_followed_user === null) {
            $auth_user = User::find(Auth::id());
            $auth_user->followers()->create(["following" => $id]);
        } else {
            $follower_and_followed_user->delete();
        }
        return redirect()->back();

    }

}
