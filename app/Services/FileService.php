<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/6/2
 * Time: 上午10:46
 */

namespace App\Services;


use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Storage;

class FileService implements InterfaceServiceHandler
{
    public function handle()
    {
        $args = func_get_args();
        $method = $args[0];
        $args = array_shift($args);
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
        $disk = Storage::disk($disk);
        $file = $request->file('file');
        $realPath = $file->getRealPath();
        $ext = $file->getExtension();
        $name = $file->getClientOriginalName();
        $newName = md5($name);
        $path = ends_with('/', $path)? $path : $path.'/';
        $filePath = $path.$newName.'.'.$ext;
        $content = file_get_contents($realPath);
        return $disk->put($filePath, $content);
    }

    protected function delete(string $file, string $disk = 'oss')
    {
        $disk = Storage::disk($disk);
        return $disk->delete($file);
    }
}