<?php

namespace Tusker\Framework\FileSystem;

use Tusker\Framework\Exception\FileSystemException;

class FileWriter implements FileWriterInterface
{
    private string $filePath = '';

    /**
     * store file data
     *
     * @var mixed $file|
     */
    private $file = null;

    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

     /**
     * create writer for file 
     *
     * @return void
     */
    public function create(): void
    {
        if (empty($this->filePath)) {
            throw new FileSystemException('No file path specified', 5000);
        }
        try {
            if (!file_exists($this->filePath)) {
                $this->open('w');
                $this->close();
            }
        } catch (\Throwable $th) {
            throw new FileSystemException($th->getMessage(), $th->getCode(), $th);
        }
    }

    /**
     * use to write text in files
     *
     * @param string $text
     * @return void
     */
    public function write(string $text): void
    {
        fwrite($this->file, $text);
    }

    public function open(string $mode = 'a'): void
    {
        try {
            $this->file = fopen($this->filePath, $mode);
        } catch (\Throwable $th) {
            throw new FileSystemException($th->getMessage(), $th->getCode(), $th);
        }

        if (!$this->file) {
            throw new FileSystemException('File can not be opened');
        }
    }

    public function close(): void
    {
        try {
            fclose($this->file);
        } catch (\Throwable $th) {
            throw new FileSystemException($th->getMessage(), $th->getCode(), $th);
        }
    }

    public function read(): string
    {
        return fgets($this->file);
    }

    public function readAll(): string
    {
        return fgets($this->file, filesize($this->filePath));
    }

    public function isEnd(): bool
    {
        return feof($this->file);
    }

    public function delete(): bool
    {
        return unlink($this->filePath);
    }
}
