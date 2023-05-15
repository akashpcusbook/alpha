<?php

namespace App\Tusker\Parsers;

use Dotenv\Dotenv;

class EnvParser
{
    public function __construct()
    {
        Dotenv::createImmutable(getcwd())->load();
    }
}
