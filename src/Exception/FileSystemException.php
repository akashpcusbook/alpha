<?php

namespace Tusker\Framework\Exception;

use Exception;
use Throwable;

class FileSystemException extends Exception
{
    public function __construct(string $message, int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
