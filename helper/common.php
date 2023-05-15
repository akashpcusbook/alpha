<?php

/**
 * return env variable data If fails then returns null
 *
 * @param string $key
 * @param mixed $alt
 * @return mixed
 */
function env(string $key, mixed $alt = null): mixed
{
    return $_ENV[$key] ?? $alt;
}
