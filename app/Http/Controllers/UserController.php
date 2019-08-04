<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use App\Helpers\Functions;
use Validator;

class UserController extends Controller
{

    protected function get(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return Functions::sendError('Erro na validacao', $validator->errors(), 401);       
        }
        $user = User::where('email', $data['email'])->where('password', $data['password'])->first();;
        if ($user){
            return Functions::sendResponse($user->toArray(), "");
        }
        return Functions::sendError('Usuario nao encontrado', [], 401);       
    }

    protected function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return Functions::sendError('Erro na validacao', $validator->errors(), 401);       
        }
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'lastName' => $data['lastName'],
            'password' => $data['password'],
            'api_token' => Str::random(60),
        ]);
        return Functions::sendResponse($user->toArray(), 'Usuario criado com sucesso.');
    }
}


