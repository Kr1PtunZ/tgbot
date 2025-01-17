<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
class FileService
{
    public function getFileInfo($fileId, $messageType, $token)
    {
        $fileInfo = $this->getFile($fileId, $token);
        if ($fileInfo) {
            $filePath = $fileInfo['file_path'];
            $fileName = $messageType === 'photo' ? basename($filePath) : $fileInfo['file_name'];
            $fileSize = $fileInfo['file_size'];
            return "Вы отправили " . ($messageType === 'photo' ? "изображение" : "документ") . ":\nИмя файла: $fileName\nРазмер: $fileSize байт";
        }
        return null;
    }
    private function getFile($fileId, $token)
    {
        $url = "https://api.telegram.org/bot$token/getFile?file_id=$fileId";
        $response = Http::get($url);
    
        if ($response->successful() && isset($response['result'])) {
            return $response['result'];
        }
        return null;
    }
}