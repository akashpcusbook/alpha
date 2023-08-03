<?php

namespace Tusker\Framework\Support;

class System
{
    public static function upload($from, $to): bool
    {
        return move_uploaded_file($from, $to);
    }

    public static function checkFile(string $filePath): bool
    {
        return file_exists($filePath);
    }

    public static function checkDir(string $dirPath): bool
    {
        return is_dir($dirPath);
    }

    public static function createDir(string $dirPath): bool
    {
        return mkdir($dirPath, 0777, true);
    }

    public static function deleteDir(string $dirPath): bool
    {
        return rmdir($dirPath);
    }
}
