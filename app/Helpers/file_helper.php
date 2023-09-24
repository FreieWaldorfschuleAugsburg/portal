<?php

namespace App\Helpers;

use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\IncomingRequest;
use RecursiveDirectoryIterator;

function storeFile(IncomingRequest $request): ?string
{
    $file = $request->getFile('userUploadFile');
    if ($file->isValid() && !$file->hasMoved()) {
        $fileName = getFileName($file);
        $file->move(getUserUploadsFolder(), $fileName);
        return getFilePath($fileName);
    }
    return null;
}

function readCsvToArray(string $fileName): array
{
    $csv = [];
    $file = fopen($fileName, 'r');
    while (($row = fgetcsv($file)) !== false) {
        $row = mb_convert_encoding($row, 'UTF-8', mb_list_encodings());
        $row = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $row);

        if (empty($keys)) {
            $keys = explode(';', $row[0]);
        } else {
            $row = explode(';', $row[0]);
            if (count($row) > count($keys)) {
                $row = array_slice($row, 0, count($keys));
            } else {
                $row = array_pad($row, count($keys), '');
            }
            $csv[] = array_combine($keys, $row);
        }
    }
    fclose($file);
    unlink($fileName);
    return $csv;
}

function getFileName(UploadedFile $file): string
{
    return $file->getRandomName();
}

function getUserUploadsFolder(): string
{
    return WRITEPATH . "uploads/users/";
}

function getFilePath(string $fileName): string
{
    return getUserUploadsFolder() . $fileName;
}