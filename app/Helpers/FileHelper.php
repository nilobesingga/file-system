<?php
namespace App\Helpers;

use App\Models\Files;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    /**
     * Get unread files count
     */
    public static function getNotication()
    {
        $unreadFilesCount = Files::where('is_delete', 0)->whereDoesntHave('readers', function ($query) {
            $query->where('user_id', Auth::id());
        });
        if (!Auth::user()->is_admin) {
            $unreadFilesCount->where('user_id', Auth::id());
        }
        return $unreadFilesCount->count();
    }

    /**
     * Get unread files
     */
    public static function getUnreadFiles()
    {
        $query = Files::where('is_delete', 0)->whereDoesntHave('readers', function ($query) {
            $query->where('user_id', Auth::id());
        });

        if (!Auth::user()->is_admin) {
            $query->where('files.user_id', Auth::id());
        }
        return $query->get();
    }

    /**
     * Get unread notifications
     */
    public static function getUnreadNotifications()
    {
        $unreadFiles = self::getUnreadFiles();
        $notifications = [];

        foreach ($unreadFiles as $file) {
            $notifications[] = [
                'id' => $file->id,
                'message' => $file->document_name,
            ];
        }

        return $notifications;
    }

    public static function generateStatementRef()
    {
        $prefix = 'CLP';
        $currentYear = date('y');

        // Get the latest reference number for the current year
        $lastRef = DB::table('statement_series')
            ->select(DB::raw('MAX(SUBSTRING_INDEX(statement_no, "-", -1)) as last_count'))
            ->whereRaw('statement_no LIKE ?', ["$prefix-$currentYear-%"])
            ->first();

        // Start counter at 0 if no previous references or start a new year
        $count = $lastRef && isset($lastRef->last_count) ? (int)$lastRef->last_count : 0;

        // Increment counter
        $count++;

        // Format counter to 3 digits
        $formattedCount = str_pad($count, 3, '0', STR_PAD_LEFT);

        // Generate reference number
        $referenceNumber = sprintf('%s-%s-%s', $prefix, $currentYear, $formattedCount);

        // No need to store in the table here as this would typically be
        // done when creating the actual statement record

        return $referenceNumber;
    }
}
