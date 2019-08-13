<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Favorite;
use App\Helpers\Functions;
use Validator;

class FavoriteController extends Controller
{
    protected function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'point_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return Functions::sendError('Erro na validacao', $validator->errors(), 401);       
        }
        $user = User::where('api_token', $request->header('token'))->first();
        $favorite = Favorite::where('fk_user', $user->id)->where('fk_point', $data['point_id'])->first();
        if ($favorite == null){
            $favorite = Favorite::create([
                'fk_user' => $user->id,
                'fk_point' => $data['point_id']
            ]);
            return Functions::sendResponse($favorite->toArray(), 'Ponto favoritado com sucesso.');
        }
        return Functions::sendError("Ponto já favoritado!","", 401);       
    }
    protected function delete(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'favorite_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return Functions::sendError('Erro na validacao', $validator->errors(), 401);       
        }
        $user = User::where('api_token', $request->header('token'))->first();
        $favorite = Favorite::where('fk_user', $user->id)->where('id', $data["favorite_id"])->first();
        if($favorite){
            Favorite::where('id',$data['favorite_id'])->delete();
            return Functions::sendResponse("", 'Ponto desfavoritado com sucesso.');
        }
        return Functions::sendError('Falha ao desfavoritar ponto.', "", 401);       
    }
}
