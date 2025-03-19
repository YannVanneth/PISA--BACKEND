<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Illuminate\Http\UploadedFile;

class GoogleDriveService
{
    private $client;
    private $service;
    private $folderId;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('app/google-credentials.json'));
        $this->client->addScope(Drive::DRIVE_FILE);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('consent');
        
        $this->service = new Drive($this->client);
        $this->folderId = env('GOOGLE_DRIVE_FOLDER_ID');
    }

    public function uploadFile(UploadedFile $file, $fileName = null)
    {
        try {
            $fileName = $fileName ?? time() . '.' . $file->getClientOriginalExtension();
            
            $fileMetadata = new DriveFile([
                'name' => $fileName,
                'parents' => [$this->folderId]
            ]);

            $content = file_get_contents($file->getPathname());
            
            $file = $this->service->files->create($fileMetadata, [
                'data' => $content,
                'mimeType' => $file->getMimeType(),
                'uploadType' => 'multipart',
                'fields' => 'id, webViewLink'
            ]);

            return [
                'id' => $file->id,
                'url' => $file->webViewLink
            ];
        } catch (\Exception $e) {
            \Log::error('Google Drive upload error: ' . $e->getMessage());
            return null;
        }
    }
} 