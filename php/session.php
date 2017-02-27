<?php

class SimpleSession     // Session name is used by Symfony
{
    public static function addVar($arr)
    {
        foreach ($arr as $key => $val) {
            $_SESSION[$key] = $val;
        }
    }

    public static function getVar($idx)
    {
        return $_SESSION[$idx];
    }

    public static function start()
    {
        if (!isset($_SESSION)) {
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
