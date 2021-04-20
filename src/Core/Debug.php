<?php

namespace Core;

class Debug {
    public static  function dump($a) {
        echo '<pre>';
        var_dump($a);
        echo '</pre>';
    }
    public static  function print($a) {
        echo '<pre>';
        print_r($a);
        echo '</pre>';
    }
}