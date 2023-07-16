<?php

namespace Tusker\Framework\Exception;

use Tusker\Framework\Response\HttpResponse;

class ApiException extends \Exception
{
    public function __construct(string $message, int $code = 0, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        $error = __CLASS__ . ": [{$this->code}]: {$this->message}";
        
        return HttpResponse::json(
            [
                'error' => $error
            ],
            'api exception',
            HttpResponse::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
