<?php
# Versión del sistema
const VERSION = "desa";
const SO_UNIX = false;

# Credenciales para la conexión con la base de datos MySQL
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 's2obras';


# Algoritmos utilizados para la encriptación de credenciales
# para el registro y acceso de usuarios del sistema
const ALGORITMO_USER = 'crc32';
const ALGORITMO_PASS = 'sha512';
const ALGORITMO_FINAL = 'md5';


# Direcciones a recursos estáticos de interfaz gráfica
if (SO_UNIX == true) {
	define('URL_APP', "/GenerInc");
	define('URL_STATIC', "/GenerInc/static/theme/");
} else {
	define('URL_APP', "/GenerInc");
	define('URL_STATIC', "/GenerInc/static/theme/");
}

# Configuración estática del sistema
const APP_TITTLE = "Seguimieto de Obras";
const APP_VERSION = "v1.0";
const APP_ABREV = "GenerInc";
const LOGIN_URI = "/usuario/login";
const DEFAULT_MODULE = "usuario";
const DEFAULT_ACTION = "login";
const URL_APPFILES = "/var/www/html/GenerInc/private/archivos/";
const TEMPLATE = "static/template.html";

define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
ini_set('include_path', DOCUMENT_ROOT);

session_start();
$session_var = "login" . APP_ABREV;
$session_vars = array("{$session_var}"=>false);
foreach($session_vars as $var=>$value) {
    if(!isset($_SESSION[$var])) $_SESSION[$var] = $value;
}
?>
