<?php
spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    if (strtolower(substr($file, 0, strlen('horoscope'))) == 'horoscope') {
        $file = substr($file, strlen('horoscope'));
    }
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if (empty($ext)) {
        $file = $file . '.php';
    }
    $full_path = dirname(__FILE__) . '/' . $file;
    if (file_exists($full_path)) {
        require_once $full_path;
    } else {
        echo sprintf('%s not found.', $full_path);
    }
});