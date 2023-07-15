<?php

namespace Tusker\Framework\Request;

class Server
{
    /**
     * returns server details
     *
     * @return array<mixed, mixed>
     */
    public static function getServerDetails(): array
    {
        return $_SERVER;
    }

    /**
     * returns speisific server details by key
     *
     * @param string $key
     * @return string|integer|null
     */
    public static function get(string $key): string|int|null
    {
        return $_SERVER[$key]?? null;
    }
}
