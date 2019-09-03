<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use App\Helpers\Functions;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailUser;
use Hash;

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
        $user = User::where('email', $data['email'])->first();;
        if ($user && Hash::check($data['password'],$user->password)){
                return Functions::sendResponse($user->toArray(), "");
        }
        return Functions::sendError('Usuário nao encontrado', [], 401);       
    }

    protected function update(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'id' => 'required|numeric',
            'token' => 'required',
            'new_password'=> 'required'
        ]);
        if($validator->fails()){
            return Functions::sendError('Erro na validacao', $validator->errors(), 401);       
        }
        $user = User::where('id', $data['id'])->first();
        if ($data['token'] == md5($user->email.$user->api_token.$user->updated_at)){
            $newData['password'] = Hash::make($data['new_password']);
            $user->update($newData);
            return Functions::sendResponse($user->toArray(), "");
        }
        return Functions::sendError('Usuário nao encontrado', [], 401);       
    }

    protected function sendEmailRecoverPass(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required'
        ]);
        if($validator->fails()){
        }
        $user = User::where('email', $data['email'])->first();
        if ($user != null){
            $data = array(
                'name' => $user->name,
                'token' => md5($user->email.$user->api_token.$user->updated_at),
                'id' => $user->id
            );
            Mail::to('iiurydias@hotmail.com')->send(new SendMailUser($data));
            return Functions::sendResponse('', 'Email enviado com sucesso!');
        }
        return Functions::sendError('Nenhum usuário encontrado com esse email!','', 401);       

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
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(60),
        ]);
        return Functions::sendResponse($user->toArray(), 'Usuario criado com sucesso.');
    }
}


