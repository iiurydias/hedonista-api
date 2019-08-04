<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Favorite;
use App\Category;
use App\Helpers\Functions;

class HomeDataController extends Controller
{
    protected function get(Request $request)
    {
        $categories = Category::get();
        $data = $request->all();
        $user = User::where('api_token', $data['token'])->first();
        $favorites = Favorite::where('fk_user', $user->id)->with("point")->get();
        $dados['categories'] = $categories->toArray();
        $dados['favorites'] = $favorites->toArray();
        return Functions::sendResponse($dados, "");
    }
}
