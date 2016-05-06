<?php
define('APPLICATION_PATH', 'application/');
define('SYSTEM_PATH', 'system/');
ini_set('display_errors', E_ALL);
spl_autoload_register(function ($class_name) {
    $sys = SYSTEM_PATH;
    $app = APPLICATION_PATH;
    $dirs = array(
        'model/',
        'model/errorhandling/',
        'model/domain/',
        'model/domain/general/',
        'model/domain/user/',
        'model/domain/review/',
        'model/dao/',
        'model/dao/general/',
        'model/dao/user/',
        'model/dao/user/dist/',
        'model/dao/user/notification/',
        'model/service/',
        'controller/',
        'controller/validation/',
        'controller/model-controllers/',
        'controller/page-controllers/',
        'controller/session/'
    );
    $fileFound = false;
    foreach ($dirs as $dir) {
        if (file_exists($app . $dir . strtolower($class_name) . '.php')) {
            require_once($app . $dir . strtolower($class_name) . '.php');
            $fileFound = true;
            return;
        } else if (file_exists($sys . $dir . strtolower($class_name) . '.php')) {
            require_once($sys . $dir . strtolower($class_name) . '.php');
            $fileFound = true;
            return;
        } else {
            $fileFound = false;
        }
    }
    if (!$fileFound) {
//        require_once '/model/errorhandling/errorlogger.php';
//        ErrorLogger::logError(new ControllerException('could not initiate website', NULL));
    }
});

try {
    $controller = new MasterController();
    $controller->processRequest();
} catch (Exception $ex) {
    Globals::cleanDump($ex);
}

?>
<script>
    $scriptRoot = '<?php echo Globals::getRoot('view', 'sys') ?>';
    $viewRoot = '<?php echo Globals::getRoot('view', 'app') ?>';
    $viewRootServer = '<?php echo Globals::getRoot('view', 'app', true) ?>';
</script>