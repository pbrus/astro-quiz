<?php

namespace Brus;

class Session
{
    public static function addVar($all)
    {
        foreach ($all as $key => $val) {
            $_SESSION[$key] = $val;
        }
    }

    public static function getVar($name)
    {
        return $_SESSION[$name];
    }

    public static function updateVar($name, $upValue)
    {
        $tmp[$name] = $upValue;
        self::addVar($tmp);
    }

    public static function start()
    {
        if (isset($_SESSION) === FALSE) {
            session_start();
        }
    }

    public static function stop()
    {
        if (isset($_SESSION)) {
            session_destroy();
        }
    }
}
