<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // $response = Http::get('http://127.0.0.1:8000/api/tasks');
        // return response()->json($response);

        $client = new \GuzzleHttp\Client();
        $request = $client->get('http://127.0.0.1:8000/api/tasks');
        $response = $request->getBody();

        dd($response);

        return view('task');
    }
}
