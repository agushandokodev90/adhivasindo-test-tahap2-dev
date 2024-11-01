<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\SigninRequest;
use App\Models\User;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use JsonResponse;

    public function signinAction(SigninRequest $request)
    {
        $credential = $request->only('email','password');
        if(!$auth = auth()->attempt($credential))
        {
            return $this->errorResponse('Email atau password anda salah',401);
        }

        if(auth()->user()->status =='pending'){
            return $this->errorResponse('Akun anda belum aktif', 401);
        }

        $data = array(
            'access_token' => $auth,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        );
        return $this->successResponse($data);
    }

    public function registerAction(RegisterRequest $request)
    {
        $payload = $request->validated();
        $payload['as']='kasir';
        $payload['status'] = 'pending';
        User::create($payload);
        return $this->successResponse($request->validated());
    }

    public function signoutAction()
    {
        auth()->logout();
        return $this->successResponse();
    }
}
