<?php

namespace Tusker\Framework\Response;

use Tusker\Framework\Request\Server;

class HttpHeader
{
    public static function set(string $key, mixed $value, bool $replace = true): void
    {
        header($key.': '.$value, $replace);
    }

    public static function cors()
    {
        self::set(
            'Access-Control-Allow-Origin',
            is_null(Server::get('Access-Control-Allow-Origin')) ? '*' : Server::get('Access-Control-Allow-Origin')
        );
        self::set(
            'Access-Control-Allow-Headers',
            is_null(Server::get('Access-Control-Allow-Headers')) ? '*' : Server::get('Access-Control-Allow-Headers')
        );
    }
}
