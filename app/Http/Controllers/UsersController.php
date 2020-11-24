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
}
