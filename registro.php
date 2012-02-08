<?php
require_once('lib/includeLibs.php');
require_once('class/registro.class.php');

$class = new registro;

switch($_GET['action']) {
	
    case "guardarUsuario" :
        echo $class->guardarUsuario();
    break;
	
	case "guardarRol" :
        echo $class->guardarRol();
    break;
	
	case "guardarPizarron" :
        echo $class->guardarPizarron();
    break;
	
	case "guardarEditarPizarron" :
        echo $class->guardarEditarPizarron();
    break;
	
	case "solicitarAmistad" :
        echo $class->solicitarAmistad();
    break;
	
	case "verFormImg" :
        echo $class->verFormImg();
    exit();
	
	case "verFormImg2" :
        echo $class->verFormImg2();
    exit();
	
	case "guardarConfirmar" :
        echo $class->guardarConfirmar();
    exit();
	case "guardaEditaPerfil" :
        echo $class->guardaEditaPerfil();
    break;
	
	
}

echo $class->Display();
?>