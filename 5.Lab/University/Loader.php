<?php

spl_autoload_register(/**
 * @throws Exception
 */ function ($className) {
    $parts = explode('\\', $className);
    $file = end($parts) . '.php';
    if (file_exists($file)) {
        include $file;
    } else {
        throw new Exception("Unable to load $file");
    }
});
