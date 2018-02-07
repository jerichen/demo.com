<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Storage\StorageClient;
use League\Flysystem\Filesystem;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;

class UpdateController extends Controller 
{

    protected function getFileName($file) 
    {
        $original_name = $file->getClientOriginalName();
        $original_ext = $file->getClientOriginalExtension();

        $without_ext = preg_replace('/\\.[^.\\s]{3,4}$/', '', $original_name);
        return time() . '.' . $original_ext;
    }

    public function index() 
    {
        return view('index');
    }

    public function updatePost(Request $request) 
    {
        $file = $request->file('fileToUpload');
        $file_name = $this->getFileName($file);

        $json_path = app_path('Http/Controllers/Auth/storage.json');

        $storageClient = new StorageClient([
            'projectId' => 'cw-web-service',
            'keyFilePath' => $json_path,
        ]);
        $bucket = $storageClient->bucket('dev-cms-cw-com-tw');

        $adapter = new GoogleStorageAdapter($storageClient, $bucket);

        $filesystem = new Filesystem($adapter);
        $filesystem->put($file_name, file_get_contents($file));
        
        dd($file_name);
    }

}
