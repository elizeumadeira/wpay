<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Url;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $urls = Url::all();
        $urls = DB::table('urls')->select('id', 'url', 'status_code')->get();
        return response()->json($urls);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'url' => 'required|url'
		]);

		if ($validator->fails()) {
			return response()->error([
				'response' => [
					'validation' => $validator->errors()
				]
			]);
		}

        $url = new Url;
        $url->url = $request->input('url');
        $url->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Url = Url::find($id);

        if (!$Url) {
            return response()->json([
                'message' => 'Url não encontrada'
            ], 404);
        }

        return response()->json($Url, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
			'url' => 'required|url'
		]);

		if ($validator->fails()) {
			return response()->error([
				'response' => [
					'validation' => $validator->errors()
				]
			]);
		}

        $url = Url::find($id);
        $url->url = $request->input('url');
        $url->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Urls = Url::find($id);

        if (!$Urls) {
            return response()->json([
                'message' => 'Url não encontrada'
            ], 404);
        }

        $Urls->delete();

        return response()->json([
            'message' => 'Url excluída com sucesso',
        ], 200);
    }
}
