<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
// use Illuminate\Pagination\Paginator;

// use JWTAuth;
// use Tymon\JWTAuth\Exceptions\JWTException;

class UsersController extends Controller
{
    //
    public function index()
    {
        $User = User::all();
        return response()->json($User);
    }

    public function show($id)
    {
        $User = User::find($id);

        if (!$User) {
            return response()->json([
                'message' => 'Usuario não encontrado'
            ], 404);
        }

        return response()->json($User, 201);
    }

    public function store(Request $request)
    {
        $User = new User;
        $User->fill($request->all());
        $User->save();
        return response()->json($User, 201);
    }

    public function update(Request $request, $id)
    {
        $User = User::find($id)->first();
        if (!$User) {
            return response()->json([
                'message' => 'Usuario não encontrado'
            ], 404);
        }

        $User->fill($request->all());
        $User->save();

        return response()->json($User, 201);
    }

    public function destroy($id)
    {
        $User = User::find($id);

        if (!$User) {
            return response()->json([
                'message' => 'Usuario não encontrado'
            ], 404);
        }

        $User->delete();

        return response()->json([
            'message' => 'Usuario excluído com sucesso',
        ], 200);
    }

    public function get_user_pagination(Request $request) {
        $numero_pagina = $request->input('page');
        $numero_pagina = $numero_pagina ? $numero_pagina : 1;

        $user_per_page = $request->input('users_per_page');
        $user_per_page = $user_per_page ? $user_per_page : 10;
        $filtro =  json_decode($request->input('filtro'), true) ;

        $filtros_where = [];

        if($filtro['nome']){
            $filtros_where[] = ['nome', 'LIKE', '%'.$filtro['nome'].'%'];
        }
        if($filtro['email']){
            $filtros_where[] = ['email', 'LIKE', '%'.$filtro['email'].'%'];
        }
        if($filtro['phone']){
            $filtros_where[] = ['phone', 'LIKE', '%'.$filtro['telefone'].'%'];
        }

        // $sql = User::where($filtros_where)->toSql();

        $pagina = User::where($filtros_where)->paginate(
            $user_per_page, ['*'], 'page', $numero_pagina
        );

        return response()->json([
            'current_page' => $pagina->currentPage(),
            'last_page' => $pagina->lastPage(),
            'total' => $pagina->total(),
            'per_page' => $pagina->perPage(),
            'data' => $pagina->items()
        ]);
    }
}
