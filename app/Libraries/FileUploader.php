<?php

namespace App\Libraries;

use CodeIgniter\Exceptions\CriticalError;
use CodeIgniter\HTTP\Files\UploadedFile;

class FileUploader
{
    protected string $relativeDir;
    protected string $uploadDir;

    public function __construct(string $relativeDir = 'assets/userPhotos')
    {
        $this->relativeDir = trim($relativeDir, '/');
        $this->uploadDir   = rtrim(FCPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $this->relativeDir . DIRECTORY_SEPARATOR;
    }

    public function upload(?UploadedFile $file): ?string
    {
        if ($file === null || !$file->isValid()) {
            return null;
        }

        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, ['image/jpeg', 'image/png'], true)) {
            throw new CriticalError('Solo se permiten imagenes JPG o PNG');
        }

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }

        $fileName = $file->getRandomName();
        $file->move($this->uploadDir, $fileName);

        return $this->relativeDir . '/' . $fileName;
    }

    public function delete(?string $filePath): void
    {
        if (empty($filePath)) {
            return;
        }

        $fileName = basename($filePath);
        $absolute = $this->uploadDir . $fileName;

        if (is_file($absolute)) {
            unlink($absolute);
        }
    }
}
