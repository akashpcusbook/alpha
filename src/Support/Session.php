<?php

namespace Tusker\Framework\Support;

/**
 * It is used to perform Session Based Operations.
 */
class Session
{
    /**
     * It is used to start session.
     *
     * @return void
     */
    public static function start(): void
    {
        global $config;

        $path = app_path('var/session');
        \session_save_path($path);
        \session_start();
        \session_regenerate_id(true);

        self::remove('temp');
    }

    /**
     * It is used to set session.
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public static function set(string $name, $value): void
    {
        $_SESSION[$name] = $value;
    }

    /**
     * It is used to get session.
     *
     * @param string $name
     * @return string
     */
    public static function get(string $name): string
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : '';
    }

    /**
     * It is used to remove session.
     *
     * @param string $name
     * @return void
     */
    public static function remove(string $name = ''): void
    {
        if (empty($name)) {
            \session_unset();
        } else {
            unset($_SESSION[$name]);
        }
    }

    /**
     * It is used to destroy session.
     *
     * @return void
     */
    public static function destroy(): void
    {
        \session_destroy();
    }

    /**
     * It is used to get status of the session.
     *
     * @return integer
     */
    public static function status(): int
    {
        return \session_status();
    }

    /**
     * It is used to create temporary session.
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public static function temp(string $name, $value): void
    {
        $_SESSION['temp'][$name] = $value;
    }
}
