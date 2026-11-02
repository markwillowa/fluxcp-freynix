<?php
define('FLUX_ROOT', 'C:/xampp/htdocs/fluxcp-freynix');
define('FLUX_DATA_DIR', 'data');
define('FLUX_CONFIG_DIR', 'config');
define('FLUX_LIB_DIR', 'lib');
define('FLUX_MODULE_DIR', 'modules');
define('FLUX_THEME_DIR', 'themes');
define('FLUX_ADDON_DIR', 'addons');
define('FLUX_LANG_DIR', 'lang');
set_include_path(FLUX_LIB_DIR . PATH_SEPARATOR . get_include_path());
require_once FLUX_CONFIG_DIR.'/groups.php';
require_once 'Flux.php';
require_once 'Flux/Dispatcher.php';
require_once 'Flux/SessionData.php';
require_once 'Flux/DataObject.php';
require_once 'Flux/Authorization.php';
require_once 'Flux/Installer.php';
require_once 'Flux/Template.php';

Flux::initialize(array(
    'appConfigFile' => FLUX_CONFIG_DIR.'/application.php',
    'serversConfigFile' => FLUX_CONFIG_DIR.'/servers.php'
));

$sess = array();
Flux::$sessionData = new Flux_SessionData($sess);

$accessConfig = Flux::parseConfigFile(FLUX_CONFIG_DIR.'/access.php');
$authComponent = Flux_Authorization::getInstance($accessConfig, Flux::$sessionData);

$serverNames = array_keys(Flux::$loginAthenaGroupRegistry);
$server = Flux::$loginAthenaGroupRegistry[$serverNames[0]];

$arr = array(
    'basePath' => Flux::config('BaseURI'),
    'themePath' => FLUX_THEME_DIR,
    'themeName' => 'celestial',
    'modulePath' => FLUX_MODULE_DIR,
    'moduleName' => 'main',
    'actionName' => 'index',
    'viewName' => 'index',
    'headerName' => 'header',
    'footerName' => 'footer'
);
$tplConfig = new Flux_Config($arr);
$template = new Flux_Template($tplConfig);
$pArr = array('module' => 'main', 'action' => 'index');
$params = new Flux_Config($pArr);

$defaultData = array(
    'auth' => $authComponent,
    'session' => Flux::$sessionData,
    'params' => $params,
    'server' => $server
);
$template->setDefaultData($defaultData);

ob_start();
try {
    $template->render();
    $html = ob_get_clean();
    file_put_contents('scratch/rendered_celestial.html', $html);
    echo "SUCCESS: Rendered " . strlen($html) . " bytes\n";
} catch (Throwable $e) {
    ob_end_clean();
    echo "ERROR: " . $e->getMessage() . "\nin " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo $e->getTraceAsString();
}
