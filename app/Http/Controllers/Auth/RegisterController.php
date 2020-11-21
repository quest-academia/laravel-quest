<?php
// RegisterControllerクラスの名前空間
namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    
    // トレイト：関数がまとめて定義している
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //  アクセス権限
    //  public:どのクラスでもこの変数・関数にアクセスできる
    //  protected:変数・関数にアクセス可能なのは、継承関係のあるクラスのみ
    
    // ゲスト以外の場合→ホームに戻る
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     
    //  処理がコントローラに渡る前に実行される内容
    // この処理をする場合ログインしていない人だけに実行
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
     
    //  行為の制限をするために使われている
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
