<?php
if (!function_exists("p")) {
    /**
     * 打印，放个p
     * @param $arg
     */
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
