<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Helpers\Functions;
use Validator;

class CommentController extends Controller
{
    protected function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'point_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'comment' => 'required'
        ]);

        if($validator->fails()){
            return Functions::sendError('Erro na validacao', $validator->errors(), 401);       
        }
        $comment = Comment::create([
            'fk_point'=> $data['point_id'],
            'fk_user' => $data['user_id'],
            'comment' => $data['comment']
        ]);
        return Functions::sendResponse($comment->toArray(), 'Comentário feito com sucesso.');
    }
    protected function get(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'point_id' => 'required|numeric'
        ]);
        if($validator->fails()){
            return Functions::sendError('Erro na validacao', $validator->errors(), 401);       
        }
        $comments = Comment::where('fk_point', $data["point_id"])->with("author")->get();
        return Functions::sendResponse($comments->toArray(), '');    
    }
}
