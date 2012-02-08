<?php
class login
{
  function validate($login,$password)
  {
    $query = new query;
    $pass = md5($password);
    $row = $query->getRows("USERNAME, CONTRASENA, ID_USUARIO","usuario","where ESTADO='activado'");
    foreach($row as $key)
    {
      if ($key['USERNAME'] == $login)
      	if ($key['CONTRASENA'] == $pass)
      		return $key['ID_USUARIO'];
    }
    return false;
  }
  
	function loginUser($UserId)
	{
		$query = new query;
		$row = $query->getRow("*","usuario","WHERE ID_USUARIO = $UserId");
		$_SESSION['UserId'] = $row['ID_USUARIO'];
		$_SESSION['username'] = $row['NOMBRE']." ".$row['APELLIDO1'];
		$_SESSION['tipo'] = $row['ID_TIPO_USUARIO'];
		$_SESSION['UserRegisterDate'] = time::convert_datetime($row['UserRegisterDate']);
		$_SESSION['UserLastLogin'] = time::convert_datetime($row['UserLastLogin']);
		$_SESSION['ActualLogin'] = time();
		$update['UserLastLogin'] = 'NOW()';
		$query->dbUpdate($update,"usuario","WHERE ID_USUARIO = $UserId");
	}
	
	function showLogin()
	{
		$class = new template;
		if ($_SESSION['UserId'] == "")	//the user has not logged in.
		{
			$class->SetTemplate('html/login.html');
			return $class->Display();
		}
		else
		{
			if($_SESSION['tipo']==1){
				$class->SetTemplate('html/login_loggedin1.html');
				$class->SetParameter('name',$_SESSION['username']);
				$class->SetParameter('time',time::returnDifference(time(),$_SESSION['ActualLogin']));
				return $class->Display();
			}
			if($_SESSION['tipo']==2){
				$class->SetTemplate('html/login_loggedin2.html');
				$class->SetParameter('name',$_SESSION['username']);
				$class->SetParameter('time',time::returnDifference(time(),$_SESSION['ActualLogin']));
				return $class->Display();
			}
			if($_SESSION['tipo']==3){
				$query=new query;
				$id=$_SESSION['UserId'];
				$res=$query->getRow("*","iglesia","where RESPONSABLE=$id");
				if($res==1){
					$class->SetTemplate('html/login_loggedin4.html');
					$class->SetParameter('name',$_SESSION['username']);
					$class->SetParameter('time',time::returnDifference(time(),$_SESSION['ActualLogin']));
					return $class->Display();
				}
				else{
					$class->SetTemplate('html/login_loggedin3.html');
					$class->SetParameter('name',$_SESSION['username']);
					$class->SetParameter('time',time::returnDifference(time(),$_SESSION['ActualLogin']));
					return $class->Display();
				}
			}
			if($_SESSION['tipo']==4){
					$class->SetTemplate('html/login_loggedin.html');
					$class->SetParameter('name',$_SESSION['username']);
					$class->SetParameter('time',time::returnDifference(time(),$_SESSION['ActualLogin']));
					return $class->Display();
			}
			
			
		}
	}

}
?>