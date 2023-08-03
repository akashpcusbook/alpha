<?php

namespace Tusker\Framework\Support;

class File
{
    /**
     * store files details
     *
     * @var array<mixed, mixed>
     */
    private static array $files = [];

    public function __construct()
    {
        self::$files = $_FILES;
    }

    /**
     * returns all uploaded files data
     *
     * @return array<mixed, mixed>
     */
    public static function getFiles(): array
    {
        return self::$files;
    }
    
}
