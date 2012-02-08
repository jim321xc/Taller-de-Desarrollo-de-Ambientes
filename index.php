<?php
require_once('lib/includeLibs.php');
require_once('class/index.class.php');

$class = new index;

switch($_GET['accion']) {
	case "validaUsuario" :
		$class->validaUsuario();
	break;
	case "salir" :
		$class->salir();
	break;
}

echo $class->Display();
?>