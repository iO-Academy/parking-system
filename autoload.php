<?php
spl_autoload_register('class_autoloader');
spl_autoload_register('interface_autoloader');

function class_autoloader($class) {
    $file = __DIR__ . '/classes/' . $class . '.php';
    if (is_readable($file)) {
        include_once $file;
    }
}

function interface_autoloader($interface) {
    $file = __DIR__ . '/interfaces/' . $interface . '.php';
    if (is_readable($file)) {
        include_once $file;
    }
}