<?php //ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require 'config.php';
require 'util/Auth.php';

/*Directories that contain classes*/
/*Make sureto add this autoload!!*/
$classesDir = array (
    FORM_DIR.'Libs/',
    FORM_DIR.'Models/',
    FORM_DIR.'Facade/',
    LIBS
);
function __autoload($class_name) {
    global $classesDir;
    foreach ($classesDir as $directory) {
        if (file_exists($directory . $class_name . '.php')) {
            require_once ($directory . $class_name . '.php');
            return;
        }
    }
}
//include the form library
include FORM_DIR . 'forms.php';

// Load the Bootstrap!
$bootstrap = new Bootstrap();
// Optional Path Settings
//$bootstrap->setControllerPath();
//$bootstrap->setModelPath();
//$bootstrap->setDefaultFile();
//$bootstrap->setErrorFile();

$bootstrap->init();
//ob_end_flush();