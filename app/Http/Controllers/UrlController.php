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

    public  function get_data_from_url(){
        $urls = Url::where('status_code', '!=', 200)->orWhereNull('status_code')->get();

        foreach($urls as $url){
            $this->get_url_data($url);
        }
    }

    public function show_content($id){
        $url = Url::find($id);
        echo $url->body;
    }

    public function get_url_data(Url $url){
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_FOLLOWLOCATION => true
        ]);

        
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $body = substr($response, $header_size);

        curl_close($curl);

        $url->body = $body;
        $url->status_code = $httpcode;
        $url->save();
    }
}
