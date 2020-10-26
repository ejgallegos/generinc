<?php
error_reporting(0);
ini_set("session.cookie_lifetime","28800");
ini_set("session.gc_maxlifetime","28800");
/**
* SAFi - Sistema de Administración y Finanzas
*
* FrontCrontoller de la Aplicación.
* Rutea las peticiones del cliente teniendo en cuenta la estructura
* /MODULO/RECURSO/ARGUMENTO
*
* @package    SAFi
* @version    2.1
**/
header('Content-Type: text/html; charset=utf8');
require_once 'settings.php';
require_once 'core/database.php';
require_once 'core/collector.php';
require_once 'core/collector_condition.php';
require_once 'core/view.php';
require_once 'core/standardobject.php';
require_once 'core/sessions.php';
require_once 'core/helpers/configuracionmenu.php';
require_once 'core/log.php';
require_once 'tools/emailHelper.php';
require_once 'tools/excelreport.php';
require_once 'tools/rePass.php';


$peticion = $_SERVER['REQUEST_URI'];
@list($null, $app, $modulo, $recurso, $argumento) = explode('/', $peticion);

if (empty($modulo)) { $modulo = DEFAULT_MODULE; }
if (empty($recurso)) { $recurso = DEFAULT_ACTION; }
if (!file_exists("modules/{$modulo}/controller.php")) $modulo = DEFAULT_MODULE;
$archivo = "modules/{$modulo}/controller.php";

require_once $archivo;
$controller_name = ucwords($modulo) . 'Controller';
$controller = new $controller_name;
$recurso = (method_exists($controller, $recurso)) ? $recurso : DEFAULT_ACTION;
$controller->$recurso($argumento);
?>
