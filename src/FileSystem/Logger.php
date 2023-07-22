<?php

namespace Tusker\Framework\FileSystem;

use Tusker\Framework\Support\Date;

class Logger
{
    public const LEVEL_ERROR = 'e';
    public const LEVEL_INFO = 'i';
    public const LEVEL_DEBUG = 'd';

    private const LEVELS = [
        self::LEVEL_ERROR => 'error',
        self::LEVEL_DEBUG => 'debug',
        self::LEVEL_INFO => 'info'
    ];
    
    public function __construct(private FileWriter $fileWriter, private string $fileName) {}

    public function log(string $text, string $level = self::LEVEL_INFO): void
    {
        $tabSpace = '    ';
        $formatedText = '[' . Date::now() . ']';
        $formatedText .= $tabSpace. '['. self::LEVELS[$level] . ']';
        $formatedText .= $tabSpace. $text;

        $this->fileWriter->setFilePath(app_path('var/logs/'. $this->fileName));
        $this->fileWriter->open();
        $this->fileWriter->write($text);
        $this->fileWriter->close();
    }
}