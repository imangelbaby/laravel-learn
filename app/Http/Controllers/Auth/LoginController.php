<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

//微信公众平台信息
    protected $params = [
            "appid" => 'wx849ea16e0f42f232',
            "secret" => '0864a3720d5972c8bbb49e029cbd033f',
            "redirect_uri" => "http://blog-shop.com/access_token",
            "scope" => "snsapi_userinfo",
            ""
    ];


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function wxcode()
    {

      //第一步：用户同意授权，获取code
      $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->params["appid"]."&redirect_uri=".$this->params["redirect_uri"]."&response_type=code"."&scope=".$this->params["scope"]."#wechat_redirect";
      dd($url);
      // $code = file_get_contents($url);
      // dd($code);
    }
}
