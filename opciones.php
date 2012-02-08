<?php
require_once('lib/includeLibs.php');
require_once('class/opciones.class.php');

$class = new opciones;

switch($_GET['accion']) {
	case "salir" :
		$class->salir();
	break;
}

echo $class->Display();
?>