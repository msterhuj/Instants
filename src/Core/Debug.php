<?php

namespace Core;

class Debug {
    public static  function printAll($a) {
        echo '<pre>';
        print_r($a);
        echo '</pre>';
    }
}