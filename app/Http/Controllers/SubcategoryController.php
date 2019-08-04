<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategory;
use App\Helpers\Functions;
use Validator;

class SubcategoryController extends Controller
{
    protected function get(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'category_id' => 'required'
        ]);
        if($validator->fails()){
            return Functions::sendError('Erro na validacao', $validator->errors(), 401);       
        }
        $subcategories = Subcategory::where('fk_category', $data['category_id'])->get();
        return Functions::sendResponse($subcategories->toArray(), "");
    }
    protected function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required',
            'category_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return Functions::sendError('Erro na validacao', $validator->errors(), 401);       
        }
        if (!subcategory::where('name', $data['name'])->exists()) {
        $subcategory = Subcategory::create([
            'name' => $data['name'],
            'fk_category' => $data['category_id']
        ]);
            return Functions::sendResponse($subcategory->toArray(), 'Subcategoria criada com sucesso.');
        }
        return Functions::sendError('Subcategoria já existente', "", 401);       
    }
}
