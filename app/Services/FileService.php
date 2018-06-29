<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/2
 * Time: 上午10:46
 */

namespace App\Services;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileService implements InterfaceServiceHandler
{
    public function handle()
    {
        $args = func_get_args();
        $method = $args[0];
        array_shift($args);
        if($method === 'upload') {
            list($request, $path, $disk) = $args;
            return $this->upload($request, $path, $disk);
        }else if($method === 'delete') {
            list($file, $disk) = $args;
            return $this->delete($file, $disk);
        }
        // TODO: Implement handle() method.
        return null;
    }

    protected function upload(Request $request, string $path, string  $disk = 'oss')
    {
        $path = ends_with('/', $path)? $path : $path.'/';
        $path = trim($path, '/');
        $fileField = $request->input('file_field', 'file');
        $file = $request->file($fileField);
        $result = $file->store($path, ['disk' => $disk]);
        //$path = Storage::url($result);
        if($result) {
            return $result;
        }else{
            return false;
        }
    }

    protected function delete(string $file, string $disk = 'oss')
    {
        $disk = Storage::disk($disk);
        return $disk->delete($file);
    }
}