<?php

namespace App\Http\Controllers\FileManager;

use App\Repositories\FileRepository;
use App\Transformers\FileTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    //
    protected $fileService = null;
    protected $fileModel = null;
    public function __construct(FileRepository $fileModel)
    {
        $this->fileService = app('file');
        $this->fileModel = $fileModel;
    }

    public function upload(Request $request, string $driver = "default")
    {
        $fileField = $request->input('file_field', 'file');
        $uploadFile = $request->file($fileField);
        $data['mime_type'] = $uploadFile->getMimeType();
        $topDir = $request->input('dir', '');
        $data['extension'] = $uploadFile->getClientOriginalExtension();
        $path = Carbon::now()->format('Ymd');
        $path = trim($path, '/');
        $path = trim($path.'/'.trim($topDir, '/'), '/');
        $driver = config("filesystems.{$driver}");
        $result = $this->fileService->handle('upload', $request, $path, $driver);
        $tmpArr = explode('/', $result);
        $data['name'] = array_pop($tmpArr);
        $data['driver'] = $driver;
        $data['path'] = implode('/', $tmpArr);
        $data['src'] = Storage::disk($driver)->url($result);
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
            return $this->response()->error('文件上传失败！');
        }else {
            return $this->response()->item($file, new FileTransformer());
        }
    }
}
