<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WeChatController extends Controller
{
  //微信公众平台信息
      protected $params = [
              "appid" => 'wx849ea16e0f42f232',
              "secret" => '0864a3720d5972c8bbb49e029cbd033f',
              "redirect_uri" => "http://blog-shop.com/wxtoken",
              "scope" => "snsapi_userinfo",
              ""
      ];
    public function auth(Request $request)
    {
      $WeChatUserInfo = session('wechat.oauth_user.default');
      $UserInfo = User::where('Openid',$WeChatUserInfo['id'])->first();
      if (!$UserInfo) {
        $result = User::create([
          'id' => $this->uuid(),
          'Openid' => $WeChatUserInfo['id'],
          'username' => $WeChatUserInfo['name'],
          // 'password' => bcrypt(Str::random(60)),
          'role_id' => 1,
          'vender_type' => 1,
          'status' => 1,
          'login_ip' => $request->getClientIp()
        ]);
      }else{
        $result = $UserInfo;
      }

      //登录验证
      Auth::login($result,true);
            //获取跳转地址
      $redirect_url = $request->redirect_url;
      if($redirect_url == ''){
          //如果跳转地址不存在
          return redirect('/products');
      }else{
          return redirect($redirect_url);
      }
    }

    public function uuid($prefix = '')
    {
      $str = md5(uniqid(mt_rand(), true));
      $uuid  = substr($str,0,8) . '-';
      $uuid .= substr($str,8,4) . '-';
      $uuid .= substr($str,12,4) . '-';
      $uuid .= substr($str,16,4) . '-';
      $uuid .= substr($str,20,12);
      return $prefix . $uuid;
    }

    public function wxcode()
    {
      $params = http_build_query([
      'appid' => 'wx849ea16e0f42f232',
      'redirect_uri' => 'http://blog-shop.com/wxtoken',
      'response_type' => 'code',
      'scope' => 'snsapi_userinfo',
    ]);
      //第一步：用户同意授权，获取code
      $url = $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?' . $params . '#wechat_redirect';
      return redirect($url);
    }

    public function wxtoken(Request $resquest)
    {
      #根据拿到的code值去访问用户的access_token令牌
      $params = http_build_query([
              'appid' => 'wx849ea16e0f42f232',
              'secret' => '0864a3720d5972c8bbb49e029cbd033f',
              'code' => $resquest->input('code'),
              'grant_type' => 'authorization_code'
      ]);
      $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?' . $params;
      $result = file_get_contents($url);
      $access_token = json_decode($result);

      $params = http_build_query([
        'access_token' => $access_token->access_token,
        'openid' => $access_token->openid,
        'lang' => 'zh_CN'
      ]);

      $url = "https://api.weixin.qq.com/sns/userinfo?".$params;
      $UserInfo = json_decode(file_get_contents($url));
      dd($UserInfo);
    }
}
