<?php

namespace App\Tusker\Containers;

class ObjectContainer
{
    /**
     * @var array<mixed, mixed> $instances
     */
    private $instances = [];

    /**
     * Register objects by key and value
     *
     * @param string $key
     * @param string $value
     * @return self
     */
    public function register(string $key, string $value): self
    {
        if (!empty($key) && !empty($value)) {
            $this->instances[$key] = new $value();
        }

        return $this;
    }

    /**
     * returns instance based on key
     *
     * @param string $key
     * @return mixed
     */
    public function getObject(string $key): mixed
    {
        return $this->instances[$key];
    }
}
