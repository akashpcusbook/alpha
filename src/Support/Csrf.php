<?php

namespace Tusker\Framework\Support;

use Tusker\Framework\Support\Session;
use Tusker\Framework\Request\HttpRequest;

/**
 * It is used to perform csrf related operations.
 */
class Csrf
{
    public function __construct(private HttpRequest $request) {}

    /**
     * It is used to generate csrf token.
     *
     * @return void
     */
    public function generate(): void
    {
        Session::set('__csrf', hash_hmac('sha256', '_csrf token', bin2hex(random_bytes(64))));
    }

    /**
     * It is used to get csrf token.
     *
     * @return string
     */
    public function getToken(): string
    {
        return Session::get('__csrf');
    }

    /**
     * It is used to validate csrf token
     *
     * @return boolean
     */
    public function validate(): bool
    {
        if (isset($this->request->_csrf)) {
            if (hash_equals(self::getToken(), $this->request->_csrf)) {
                return true;
            } else {
                return false;
            }
        }
        Session::remove('__csrf');

        return false;
    }
}
