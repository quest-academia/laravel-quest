<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 名前空間
use App\User;
use App\Movie;

class MoviesController extends Controller
{
     // 登録のためのアクション
    public function create()
    {
      // ログインしているユーザを取得する
      $user = \Auth::user();
      // 動画の情報をIDで降順に並べる１ページに９つ
      $movies = $user->movies()->orderBy('id', 'desc')->paginate(9);
      
      $data = [
        // データをViewに渡すように書いている
        'user' => $user,
        'movies' => $movies,
      ];
      
      // $dataのなかに$user&$moviesが入っている
      return view('movies.create', $data);
    }
    
    // 保存用アクション
    public function store(Request $request)
    {

        $this->validate($request,[
          // 記述必須・文字数の制限が入っている
            'url' => 'required|max:11',
            'comment' => 'max:36',
        ]);

        // リクエストの内容を保存後直前のページにもどる
        $request->user()->movies()->create([
            'url' => $request->url,
            'comment' => $request->comment,
        ]);

        return back();
    }
    
    // 削除用アクション
    public function destroy($id)
    {
        $movie = Movie::find($id);
        
        // ログインユーザかつ登録した動画のユーザのID一致しているか
        if (\Auth::id() == $movie->user_id) {
            // 登録した動画を削除する
            $movie->delete();
        }

        return back();
    }
}
