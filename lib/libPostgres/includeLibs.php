<?php
session_start();

$path = $_SERVER['PHP_SELF'];
$tempPath = explode ("/",$path);

if (in_array("admin",$tempPath) && $tempPath[(count($tempPath) - 1)] != "index.php")
	{
		if ($_SESSION['UserType'] != '1' && $_SESSION['UserType'] != '2' && $_SESSION['UserType'] != '3')
			{
				echo "<script>window.location.href='index.php';</script>";
			}
	}

if(isset($_SERVER['HTTPS']))
	$protocol = 'https';
else
	$protocol = 'http';
/*switch($_SERVER['HTTP_HOST'])
{
	case 'localhost':
		$_cfg['host'] = 'localhost';
		$_cfg['user'] = 'postgres';
		$_cfg['pass'] = 'postgres';
		$_cfg['db'] = 'flores';
		break;
	default:
		ini_set("session.cache_expire","180");
		ini_set("session.gc_maxlifetime","3600");
		$_cfg['host'] = 'localhost';
		$_cfg['user'] = 'postgres';
		$_cfg['pass'] = 'postgres';
		$_cfg['db'] = 'flores';
		break;
}

pg_connect("dbname=".$_cfg['db']." host=".$_cfg['host']." port=5432 user=".$_cfg['user']." password=".$_cfg['pass']) or die(pg_error());
*/
require_once('email.lib.php');
require_once('login.lib.php');
require_once('paging.lib.php');
require_once('query.lib.php');
require_once('template.lib.php');
require_once('time.lib.php');
require_once('upload.lib.php');
require_once('navigation.lib.php');
require_once('matriz.lib.php');
require_once('utils.lib.php');
require_once('search.lib.php');
require_once('admin.php');

?>