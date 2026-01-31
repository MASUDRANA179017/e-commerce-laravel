<?php
use Illuminate\Support\Facades\Storage;

if (!function_exists('uploadFile')) {
    function uploadFile($file, $path)
    {
        if (!$file) {
            \Log::warning('uploadFile: File is null');
            return null;
        }
        if (!$file->isValid()) {
            \Log::warning('uploadFile: File is not valid', ['error' => $file->getError(), 'message' => $file->getErrorMessage()]);
            return null;
        }
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        try {
            $dir = 'uploads/' . trim($path, '/');
            $disk = \Illuminate\Support\Facades\Storage::disk('public');
            if (!$disk->exists($dir)) {
                $disk->makeDirectory($dir);
            }
            $stored = $disk->putFileAs($dir, $file, $fileName);
            if ($stored === false) {
                \Log::error('uploadFile: putFileAs returned false', ['dir' => $dir, 'file' => $fileName]);
                return null;
            }
            return is_string($stored) ? ($dir . '/' . $fileName) : null;
        } catch (\Throwable $e) {
            \Log::error('uploadFile failed', [
                'path' => $path,
                'file_name' => $fileName,
                'size' => method_exists($file, 'getSize') ? $file->getSize() : null,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
}

if (!function_exists('safeDeleteFile')) {
    function safeDeleteFile($filePath)
    {
        try {
            if (empty($filePath) || !is_string($filePath)) {
                return;
            }

            $filePath = trim($filePath);
            if ($filePath === '') {
                return;
            }

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            } elseif (Storage::exists('public/' . $filePath)) {
                Storage::delete('public/' . $filePath);
            }
        } catch (\Throwable $e) {
            // Log::error('File delete error: ' . $e->getMessage());
        }
    }
}

if (!function_exists('qbitDeleteFile')) {
    function qbitDeleteFile($filePath)
    {
        try {
            if (empty($filePath)) {
                return;
            }
            if (!is_string($filePath)) {
                return;
            }

            $filePath = trim($filePath);
            if (strlen($filePath) < 1) {
                return;
            }

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            } elseif (Storage::exists('public/' . $filePath)) {
                Storage::delete('public/' . $filePath);
            }
        } catch (\Throwable $e) {
            // Log::error('File delete error: ' . $e->getMessage());
        }
    }
}

if (!function_exists('deleteFile')) {
    function deleteFile($filePath)
    {
        safeDeleteFile($filePath);
    }
}
