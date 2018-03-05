<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImgurController extends Controller
{
    public function index(Request $request)
    {
        return view('imgur.index');
    }
    
    public function imgurUpload(Request $request)
    {
        $file = $request->file('file');
        
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.imgur.com/3/image', [
            'headers' => [
                'authorization' => "Client-ID " . env('IMGUR_CLIENT_ID'),
                'content-type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'image' => base64_encode(file_get_contents($file))
            ],
        ]);
        
        $res = json_decode(($response->getBody()->getContents()));
        $url = $res->data->link;
        
        if(!empty($url)){
            $result = [
                'success' => true,
                'url' => $url
            ];
        }
        
        return response()->json($result);
    }
    
    public function albumsIDs()
    {   
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.imgur.com/3/account/jerichen/albums/ids', [
            'headers' => [
                'authorization' => "Client-ID " . env('IMGUR_CLIENT_ID')
            ]
        ]);
        
        $res = json_decode(($response->getBody()->getContents()));
        $ids = $res->data;
        
        if(!empty($ids)){
            $result = [
                'success' => true,
                'ids' => $ids
            ];
        }
        
        return response()->json($result);
    }
}
