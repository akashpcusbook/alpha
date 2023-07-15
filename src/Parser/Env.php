<?php

namespace Tusker\Framework\Parser;

class Env {
    public function __construct()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(getcwd());
        $dotenv->load();
    }
}
