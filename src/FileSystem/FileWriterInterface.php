<?php

namespace Tusker\Framework\FileSystem;

interface FileWriterInterface
{
    /**
     * create writer for file 
     *
     * @return void
     */
    public function create(): void;

    /**
     * use to write text in files
     *
     * @param string $text
     * @return void
     */
    public function write(string $text): void;

    /**
     * read single line
     *
     * @return string
     */
    public function read(): string;

    /**
     * read all data
     *
     * @return string
     */
    public function readAll(): string;

    /**
     * used to check is end of file
     *
     * @return boolean
     */
    public function isEnd(): bool;

    /**
     * open a file 
     *
     * @param string $mode
     * @return void
     */
    public function open(string $mode = 'a'): void;

    /**
     * close a file
     *
     * @return void
     */
    public function close(): void;

    /**
     * delete a file
     *
     * @return bool
     */
    public function delete(): bool;
}
