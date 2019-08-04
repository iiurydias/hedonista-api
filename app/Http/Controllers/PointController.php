<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Point;
use App\User;
use App\Helpers\Functions;
use Validator;

class PointController extends Controller
{
    protected function get(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'subcategory_id' => 'required|numeric'
        ]);

        if($validator->fails()){
            return Functions::sendError('Erro na validacao', $validator->errors(), 401);       
        }
        $points = Point::where('fk_subcategory', $data['subcategory_id'])->with("author")->get();
        return Functions::sendResponse($points->toArray(), "");
    }
    protected function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'subcategory_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'name' => 'required',
            'address' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        if($validator->fails()){
            return Functions::sendError('Erro na validacao', $validator->errors(), 401);       
        }
        $point = Point::create([
            'fk_subcategory' => $data['subcategory_id'],
            'fk_user' => $data['user_id'],
            'name' => $data['name'],
            'address' => $data['address'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude']
        ]);
        return Functions::sendResponse($point->toArray(), 'Ponto criado com sucesso.');
    }
}
