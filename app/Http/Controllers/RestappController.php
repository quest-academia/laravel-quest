<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Movie;

class RestappController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // usersの変数に全てのuser情報を入れる
        $users = User::all();
        // response()->json()ひとまとめで覚えるjson形式で以下のように出力するという意味
        return response()->json(
            [
                'users' => $users    
            ],
            // ステータスコードでAPIは処理がうまくいった場合ステータスコードで返すのでうまくいけば２００で返すようにしている
            200,[],//←第三引数はレスポンスヘッダーステータスコードといくが今回は必要ないから書いていない
            // オプションjsonをどのように表示させるか
            // 二つ今回はオプションをつけている
            // 一つ目、jsonは日本語の場合は、文字化けしてしまうのでそれを避けるようにする
            // 二つ目、json形式を見やすく出るようにするためのもの
            JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(1);
        $movies = $user->movies;
        
        $data = [
            'movies' => $movies,
        ];
        
        // 外部から動画を登録できるようにする
        // フォームのViewを出すだけでいい
        return view('rest.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //外部から動画を登録をできるようにする
        // 今回はユーザIDが１ものだけ外部登録を可能にする
        $this->validate($request,[
            'url' => 'required|max:11',
            'comment' => 'max:36',
        ]);
        
        User::find(1)->movies()->create([
            'url' => $request->url,
            'comment' => $request->comment,
        ]);
        
        $movies = User::find(1)->movies;
        
        return response()->json(
            [
                'movies' => $movies
            ],
            200,[],
            JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // パラメータで渡ってきたユーザのIDによってUserを探すのを$userに入れる
        $user = User::find($id);
        // 動画を所有しているユーザの所有動画の情報も表示させる
        $movies = $user->movies;
        return response()->json(
            [
                'user' => $user,
            ],
            200,[],
            JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        $user = $movie->user;
        
        if ($user->id == 1) {
            $movie->delete();
        }
        
        $movies = $user->movies;

        return response()->json(
            [
                'movies' => $movies
            ],
            200,[],
            JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
        );
    }
}
