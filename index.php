<?php
define('ROOT', dirname(__FILE__));
define('APP', ROOT . '/Application');

spl_autoload_register(function ($className) {
    $path = preg_replace('/\\\\/', '/', $className);
    include ROOT. '/' . $path . '.php';
});

if (Application\Components\ConnectDatabase::checkConnection()) {
     $Test = new \Application\Controllers\Test();
    $Test->actionStart();
} else {
    $SetupObj = new Application\Components\Setup();
    $SetupObj->setupDB();
    echo "Database created successfully";
    header("Refresh:2");
}