<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper
{
    /**
     * Get human-readable file size
     */
    public static function getTotalSize($disk = 'public', $directory = '')
    {
        $totalSize = 0;
        $files = Storage::disk($disk)->allFiles($directory);

        foreach ($files as $file) {
            $totalSize += Storage::disk($disk)->size($file);
        }

        return self::formatFileSize($totalSize);
    }

    public static function getFileSize($filePath)
    {
        if (Storage::exists($filePath)) {
            $bytes = Storage::size($filePath);
            return self::formatFileSize($bytes);
        }
        return "File Not Found";
    }

    /**
     * Convert bytes to human-readable format (KB, MB, GB)
     */
    private static function formatFileSize($bytes, $decimal = 2)
    {
        $sizeUnits = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimal}f", $bytes / pow(1024, $factor)) . ' ' . $sizeUnits[$factor];
    }
}
