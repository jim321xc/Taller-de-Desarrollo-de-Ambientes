<?php
class index
{
	/*
	*function que carga la plantilla del formulario del login
	*/
	function formLogin(){
		$template = new template;
		$template -> SetTemplate('tpl/form_login.html');
		return $template->Display();
	}
	
	/*
	*function devuelve los datos del usuario logueado
	*/
	function formLogueado(){
		
		$template = new template;
		$template -> SetTemplate('tpl/form_logueado.html');
				
		$query = new query;
        
        $usuario = $query->getRow('*','usuario u, rol r','WHERE u.idrol=r.idrol and u.idusuario='.$_SESSION['idusuario']);
		
        $numProducto = count($usuario);
        if($numProducto > 0) {
            
				$imagen = 'images/no_image.jpg';
				if($usuario['imagenusuario'] != null || $usuario['imagenusuario'] != ""){
					$imagen  = $usuario["imagenusuario"];
				}
				$imgTip = "<img src=\"images/jpg.php?name=../{$imagen}&amp;size=200\" alt=\"{$imagenusuario['nombreusuario']}\" onmouseover=\"Tip('<img src=\\'images/jpg.php?name=../{$imagen}&amp;size=200\\'>',WIDTH, 200,TITLE,'{$usuario['nombreusuario']}', PADDING, 6, BGCOLOR, '#ffffff')\"/>";
			
        } else $list = '<div>No se encontraron registros en la base de datos</div>';
		
		$template->SetParameter('tiporol','');
		$template->SetParameter('lista',$imgTip);
		$template->SetParameter('nom',$usuario['nombreusuario']);
		
		
		return $template->Display();

	}
	
	/*
	*function que verifica la validacion de usuario
	*/
	function validaUsuario()
	{
		$login = new login;
		$iduser = $login->validate($_POST['usuario'],$_POST['password']);
		if($iduser == false)
			$_SESSION['logeado']=0;
		else
			$login->loginUser($iduser);
	}

	/*
	*function finaliza la secion 
	*/
	function salir()
	{
		session_destroy();
		$_SESSION['logeado']=0;
		echo "<script>window.location.href='index.php'</script>";
	}

	function cuenta(){
		$template = new template;
		$template -> SetTemplate('tpl/form_cuenta.html');
		return $template->Display();
	}
	function formMenu(){
		$template = new template;
		$template -> SetTemplate('tpl/form_menu.html');
		return $template->Display();
	}
	function opcion(){
		$template = new template;
		$template -> SetTemplate('tpl/form_opcion.html');
		return $template->Display();
	}
	
	function presentacion() {
		$template=new template;
		
		$template->SetTemplate('tpl/presentacion.html');
		
		$imagen = 'imagen/jpg.php?name=no_image.jpg&size=80';
		if($resProducto['pathimagen'] != null || $resProducto['pathimagen'] != ""){
			$imagen  = 'images/jpg.php?name=../'.$resProducto["pathimagen"].'&size=80';
		}
		$template->SetParameter('imagen','<img src="'.$imagen.'" />');
		return $template->Display();
	}
		
	function formOpcionUsuario(){
		$template = new template;
				
		$template->SetTemplate('tpl/form_opcion_usuario.html');
		return $template->Display();
	}
	
	
	function aviso()
	{
		$template=new template;
		$query=new query;
		$aviso = $query->getRow('count(idyo) as cant','amigos','WHERE confirmacion="No" and idel='.$_SESSION['idusuario']);
		
		if($aviso['cant']>0){
		$template->SetTemplate('tpl/aviso.html');
		$template->SetParameter('cant',$aviso['cant']);
		return $template->Display();	
		}
	}
	
	function calendario()
	{
		$template=new template;
		
		$template->SetTemplate('tpl/calendario.html');
		$template->SetParameter('titulo','Calendario');
		
		/****Calendario***/
		$nombre_mes=date(F);
		$mes=date(n);
		$anio=date(Y);
		$nombre_dia=date(D);
		$numero_mes=date(t);
		$numero_dia=date(j);
		
		$primer_dia_mes = date("w", mktime(0,0,0,$mes,1,$anio));
		if($primer_dia_mes==0){
			$primer_dia_mes=7;
		}
		$fila=ceil($numero_mes/7);
		
		 
		$tabla='<table>
				<tr>
					<th colspan="7">'.$nombre_mes.' '.$anio.'</th>
				</tr>
				<tr align="center" bgcolor="#ffffff">
					<td > L </td>		
					<td > M </td>		
					<td > M </td>		
					<td > J </td>		
					<td > V </td>		
					<td > S </td>		
					<td > D </td>
				</tr>
				<tr>';
			$d=1;
			$aux=1;
			
			for($f=1;$f<=6;$f++)
			{ 
				for($c=1;$c<8;$c++){
					if($d<=$numero_mes){
						if($aux<$primer_dia_mes){
							$tabla.='<td></td>';
							$aux++;	
						}else{
							if($d==$numero_dia){
								$Pinta='background="images/ventita.gif"';	
							}else{ $Pinta='';}
							$tabla.='<td align="center" '.$Pinta.' scope="col">'.$array[$aux++]=$d++.'</td>';
						}
					}
				}
			$tabla.='</tr>';
			}
		$tabla.='</table>';
		$calendario=$tabla;
		$template->SetParameter('opciones',$calendario);
		
		return $template->Display();
	}
	
	function Display()
	{
		$template = new template;
		$template->SetTemplate('tpl/index.html'); 
		$template->SetParameter('Keywords','php, sample, structure');
		$template->SetParameter('description','');
		$template->SetParameter('sesion','');
		$template->SetParameter('formulario','');
		$template->SetParameter('pizarron','');
		$template->SetParameter('aviso','');
		$template->SetParameter('calendario',$this -> calendario());
		
		/*
		*carga todas las plantillas cuando el usuario esta logueado
		*/
		if($_SESSION['logeado'] == 1){
			if($_SESSION['idrol'] == 1){
				$template->SetParameter('login',$this->cuenta());
				$template->SetParameter('nombre',$_SESSION['cuentausuario']);
				$template->SetParameter('usuario','');
				$template->SetParameter('formulario',$this->formLogueado());
				$template->SetParameter('menu','');
				$template->SetParameter('pizarron',$this->formOpcionUsuario());
				$template->SetParameter('aviso',$this->aviso());
				
			}else{
				$template->SetParameter('login',$this->cuenta());
				$template->SetParameter('nombre',$_SESSION['cuentausuario']);
				$template->SetParameter('usuario','');
				$template->SetParameter('formulario',$this->formLogueado());
				$template->SetParameter('menu','');
				$template->SetParameter('pizarron',$this->formOpcionUsuario());
				}	
		} else {
			$template->SetParameter('login','');
			$template->SetParameter('usuario','');
			$template->SetParameter('menu',$this->formMenu());
		}
		
		return $template->Display();
	}
}
?>