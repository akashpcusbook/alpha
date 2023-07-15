<?php

namespace Tusker\Framework\Auth;

interface AuthInterface
{
    public function authenticate(): bool;

    /**
     * @return mixed
     */
    public function getData();

    public function make(mixed $user): bool;

    public function getToken(): string;
}
