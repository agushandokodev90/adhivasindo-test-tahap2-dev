<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AddUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use JsonResponse;

    public function list(Request $request)
    {
        $data['list']=User::all();
        return $this->successResponse($data);
    }

    public function detail(User $user)
    {
        if (!$user) {
            return $this->errorResponse('User tidak ditemukan', 404);
        }

        return $this->successResponse($user);
    }

    public function addAction(AddUserRequest $request)
    {
        $payload=$request->validated();
        $payload['as']='admin';
        $payload['status'] = 'active';
        User::create($payload);
        return $this->successResponse();
    }

    public function updateAction(UpdateUserRequest $request,User $user)
    {
        if(!$user){
            return $this->errorResponse('User tidak ditemukan',404);
        }

        $user->update($request->validated());
        return $this->successResponse();
    }


    public function deleteAction(User $user)
    {
        if (!$user) {
            return $this->errorResponse('User tidak ditemukan', 404);
        }

        $user->delete();
        return $this->successResponse();
    }
}
