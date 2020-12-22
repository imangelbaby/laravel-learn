<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class UserController extends Controller
{
    //
    public function index(){
        return $this->success('退出成功...');
    }


}
