<?php
if (!function_exists("p")) {
    function p($arg)
    {
        if (is_array($arg)) {
            echo "<pre>";
            print_r($arg);
            echo "</pre>";
        } else {
            var_dump($arg);
        }
    }
}