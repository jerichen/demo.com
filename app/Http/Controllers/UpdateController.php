<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Storage\StorageClient;
use League\Flysystem\Filesystem;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;

class UpdateController extends Controller 
{

    protected $json_path;
    protected $storage_client;
    protected $bucket;
    protected $adapter;
    protected $filesystem;

    protected function init($bucket_name)
    {
        $this->json_path = app_path('Http/Controllers/Auth/storage.json');
        
        $this->storage_client = new StorageClient([
            'projectId' => 'cw-web-service',
            'keyFilePath' => $this->json_path,
        ]);
        
        $this->setBucket($bucket_name);
        $this->setAdapter();
        $this->setFilesystem();
    }

    protected function setBucket($bucket_name)
    {
        $this->bucket = $this->storage_client->bucket($bucket_name);
    }
    
    protected function setAdapter()
    {
        $this->adapter = new GoogleStorageAdapter($this->storage_client, $this->bucket);
    }

    protected function setFilesystem()
    {
        $this->filesystem = new Filesystem($this->adapter);
    }
    
    protected function setObjectPublic($file_name)
    {
        $object = $this->bucket->object($file_name);
        $object->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);
        return $object;
    }
    
    protected function getObjectUrl($file_name)
    {
        $object = $this->setObjectPublic($file_name);
        return 'https://storage.googleapis.com/' . $object->info()['bucket'] . '/' . $object->info()['name'];
    }

    protected function getFileName($file)
    {
        $original_name = $file->getClientOriginalName();
        $original_ext = $file->getClientOriginalExtension();

        $without_ext = preg_replace('/\\.[^.\\s]{3,4}$/', '', $original_name);
        return time() . '.' . $original_ext;
    }

    public function updateFile(Request $request)
    { 
        $file = $request->file('file');
        $file_name = $this->getFileName($file);
        $bucket_name = $request->get('bucket');

        $this->init($bucket_name);
        $this->filesystem->put($file_name, file_get_contents($file));
        $url = $this->getObjectUrl($file_name);
        
        if(!empty($url)){
            $result = [
                'success' => true,
                'url' => $url
            ];
        }
        
        return response()->json($result);
    }
    
    public function deleteFile(Request $request)
    {
        $bucket_name = $request->get('bucket');
    }
    
    public function index()
    {
        return view('index');
    }

}
