<?php
spl_autoload_register('class_autoloader');

function class_autoloader($class) {
    $file = __DIR__ . '/classes/' . $class . '.php';
    if (is_readable($file)) {
        include_once $file;
    }
}