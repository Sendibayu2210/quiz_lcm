<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UploadDownloadController extends BaseController
{
    public function uploadFile($file, $path)
    {        
        if ($file->isValid() && !$file->hasMoved()) {
            $folderPath = $path;
            // Membuat folder jika belum ada
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
        
            $fileName = $file->getRandomName();                
            $file->move($folderPath, $fileName); // upload
                
            // Cek apakah file sudah tersimpan
            if (file_exists($folderPath . '/' . $fileName)) {
                $status =  true;
            } else {
                $status =  false;
            }
        } else {
            $fileName = false;
            $status =  false;
        }

        $result = [
            'status' => $status,
            'fileName' => $fileName,
        ];
        return $result;        
    }
  
    public function deleteFile($filePath)
    {        
        if (file_exists($filePath)) {
            unlink($filePath);
            return true;
        } else {
            return false;
        }
    }
}
