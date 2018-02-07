<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdateController extends Controller
{
    protected function getFileName($file)
    {
        $original_name = $file->getClientOriginalName();
        $original_ext = $file->getClientOriginalExtension();
        
        $without_ext = preg_replace('/\\.[^.\\s]{3,4}$/', '', $original_name);
        return time().'.'.$original_ext;
    }
    
    public function index()
    {
        return view('index');
    }
    
    public function updatePost(Request $request)
    {
        $file = $request->file('fileToUpload');
        $file_name = $this->getFileName($file);
    }
}
