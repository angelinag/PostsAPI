<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class FetchController extends Controller
{
    public function showAll(Request $request)
    {
        if($request->page == false)
            $pageNumber = 1;
        else
        {
            $pageNumber = $request->page;
        }

        $route = getenv('FETCH_URL');
        $fetchSize = getenv('FETCH_SIZE');

        $paginationParameter = $pageNumber-1;

        $route = $route . "?_start=" . $paginationParameter*$fetchSize . "&_limit=" . $fetchSize;

        $apiResponse = Http::get("$route");
        $contents = (string) $apiResponse->getBody();
        $contents = json_decode($contents, true);

        return view('homepage')->with('contents', [$contents, $pageNumber]);;
    }

    public function showOne($id)
    {
        $route = getenv('FETCH_URL');
        $route = $route . "/" . $id;

        $response = Http::get("$route");
        $contents = (string) $response->getBody();
        $contents = json_decode($contents, true);

        return view('post')->with('contents', $contents);
    }
}
