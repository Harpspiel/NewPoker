<?php
function pokerAutoLoad($class_name) {
    $pathPrefix = '../';

    $paths[] =  $pathPrefix . $class_name . '.php';
    $paths[] =  $pathPrefix . 'Cards/' . $class_name . '.php';
    $paths[] =  $pathPrefix . 'Hands/' . $class_name . '.php';
    $paths[] =  $pathPrefix . 'Community/' . $class_name . '.php';

    foreach ($paths as $path) {
        if (file_exists($path)) {
            include_once $path;
            return;
        }
    }
};

spl_autoload_register('pokerAutoLoad');