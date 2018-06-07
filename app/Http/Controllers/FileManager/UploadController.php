<?php

namespace App\Http\Controllers\FileManager;

use App\Repositories\FileRepositoryEloquent;
use App\Transformers\FileTransformer;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class UploadController extends Controller
{
    //
    protected $fileService = null;
    protected $fileModel = null;
    public function __construct(FileRepositoryEloquent $fileModel)
    {
        $this->fileService = app('file');
        $this->fileModel = $fileModel;
    }

    public function upload(Request $request,string $topDir = '')
    {
        $path = Carbon::now()->format('Ymdh');
        $path = trim($path, '/');
        $path = trim($topDir, '/').$path;
        $result = $this->fileService->handle($request, $path);
        $driver = config('filesystems.default');
        $data['driver'] = $driver;
        $data['path'] = $path;
        switch ($driver) {
            case 'local': {
                $data['endpoint'] = config("filesystems.disks.{$driver}.root");
                break;
            }
            case 'public': {
                $data['endpoint'] = config("filesystems.disks.{$driver}.root");
                $data['bucket'] = config("filesystems.disks.{$driver}.url");
                break;
            }
            case 's3': {
                $data['endpoint'] = config("filesystems.disks.{$driver}.region");
                $data['bucket'] = config("filesystems.disks.{$driver}.bucket");
                break;
            }
            case 'oss' : {
                $data['endpoint'] = config("filesystems.disks.{$driver}.endpoint");
                $data['bucket'] = config("filesystems.disks.{$driver}.bucket");
                break;
            }
        }
        $file = $this->fileModel->create($data);
        if($result === false) {
            return $this->response()->error('图片上传失败！');
        }else {
            return $this->response()->item($file, new FileTransformer());
        }
    }
}
