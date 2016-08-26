<?php

namespace FiveSay\Laravel\Api\Controller;

/**
 * 特性：文件上传
 * 默认调用 UploadTheFile 模型
 */
trait UploadFileTrait
{
    /**
     * 上传文件
     */
    public function upload()
    {
        return $this->saveUploadFile();
    }

    /**
     * 存储用户上传的文件
     * @param  string $inputName 表单名称
     * @param  object $fileModel 文件模型实例
     * @return response
     */
    protected function saveUploadFile($inputName = 'file', $fileModel = null) {

        $fileModel = $fileModel ?: new \UploadTheFile;

        $file = request()->file($inputName);

        if ($file && $file->isValid()) {

            $md5     = md5_file($file->path());
            $hasFile = $fileModel->where('md5', $md5)->first();

            if ($hasFile) {
                return response()->json($hasFile);
            }
            else {
                $uploadsPath = 'uploads/'.date('Y-m-d');
                $extension   = $file->extension();
                $newName     = $md5.'.'.$extension;

                $file->move(public_path($uploadsPath), $newName);

                $responseData = $fileModel->create([
                    'size'        => $file->getClientSize(),
                    'client_name' => $file->getClientOriginalName(),
                    'mime_type'   => $file->getClientMimeType(),
                    'extension'   => $extension,
                    'md5'         => $md5,
                    'save_path'   => $uploadsPath.'/'.$newName,
                ]);
                return response()->json($responseData);
            }
        }
        else {
            if ($file) {
                return response()->json(['error' => '上传失败'], 400);
            }
            else {
                return response()->json(['error' => '上传失败：表单名称不匹配'], 400);
            }
        }
    }

}
