<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;//←名前空間

class UsersController extends Controller
{
    // userのアクションを追加していく
    public function index()
    {
      $users = User::orderBy('id', 'desc')->paginate(9);
      
      return view('welcome', [
        'users'=>$users,
        ]);
    }
    
    public function show($id)
    {
        $user = User::find($id);
        $movies = $user->movies()->orderBy('id', 'desc')->paginate(9);

        $data=[
            'user' => $user,
            'movies' => $movies,
        ];

        $data += $this->counts($user);

        return view('users.show',$data);
    }
    
    // この次は、Viewに追加していく
    public function rename(Request $request)
    {
        $this->validate($request,[
            'channel' => 'required|max:15',
            'name' => 'required|max:15',
        ]);
        
        $user=\Auth::user();
        $movies = $user->movies()->orderBy('id', 'desc')->paginate(9);
        
        $user->channel = $request->channel;
        $user->name = $request->name;
        // ユーザの登録ではなく、更新だからsave()を使っている
        $user->save();
        
        $data=[
            'user' => $user,
            'movies' => $movies,
        ];
        
        // データの中カウントを追加する
        $data += $this->counts($user);
        
        // show.blade.phpに$dataを持っていく
        return view('users.show', $data);
    }
    
    
    // ユーザ個別詳細ページ、フォロー中・フォロワーの一覧を表示させる様にしていく
    public function followings($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->paginate(9);

        $data = [
            'user' => $user,
            'users' => $followings,
        ];

        $data += $this->counts($user);

        return view('users.followings', $data);
    }

    public function followers($id)
    {
        $user = User::find($id);
        $followers = $user->followers()->paginate(9);

        $data = [
            'user' => $user,
            'users' => $followers,
        ];

        $data += $this->counts($user);

        return view('users.followers', $data);
    }
}
