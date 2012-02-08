<?php

/*
*class que registra a los usuarios nuevos
*/
class registro
{
	/*
	*function que devuelve si un ususario se encuentra registrado
	*/
	function listaUsuario(){
		
		$template=new template;
		$template->SetTemplate('tpl/lista_usuarios.html');
		
		$query = new query;
        
		$email=$_POST['buscar'];
		$usuario=$query->getRow('*','usuario','WHERE emailusuario="'.$_POST['buscar'].'"');
		if($usuario['idusuario']!=null){
		$verifica=$query->getRow('*','usuario','WHERE idusuario='.$usuario['idusuario'].' and idusuario in(select idyo+""+idel-""-'.$_SESSION['idusuario'].' as dato from amigos where idyo='.$_SESSION['idusuario'].' or idel='.$_SESSION['idusuario'].')');
		if($verifica['idusuario']==$usuario['idusuario'] || $_SESSION['idusuario']==$usuario['idusuario']){
			$solicitud='';
		}else{
			$solicitud='Solicitud';
		}
		$numUsuario=count($usuario);
		
			$list ='<table >';
			if($numUsuario > 0) {
				$list .='<thead><tr>
					<th colspan="2">Usuario</th>
					<th>Cuenta</th>
					<th>Solicitar Amistad</th>
				  </tr></thead>';
					
					$imagen = 'images/no_image.jpg';
					if($usuario['imagenusuario'] != null || $usuario['imagenusuario'] != ""){
						$imagen  = $usuario["imagenusuario"];
					}
					$imgTip = "<img src=\"images/jpg.php?name=../{$imagen}&amp;size=50\" alt=\"{$imagenusuario['nombreusuario']}\" />";
				
					$list .= '<tbody><tr>
					  <td>'.$imgTip.'</td>
					  <td>'.$usuario["emailusuario"].'</td>
					  <td>'.$usuario["nombreusuario"].'</td>
					  <td><a href="registro.php?action=solicitarAmistad&amp;id='.$usuario["idusuario"].'">'.$solicitud.'</a></td>
					  </tr></tbody>';
				
				$list.='</table>';
			} 
			}else {
				$list = '<div>No se encontraron registros en la base de datos</div>';
			}
		$template->SetParameter('lista',$list);
		
		return $template->Display();
	}
	
	/*
	*function incompletas sin uso 
	*/
	function formEditarRol(){
		$template = new template;
		$template->SetTemplate('tpl/form_editarRol.html');
		$query=new query;
		$datos=$query->getRow('*','usuario u,rol r','WHERE u.idrol=r.idrol and u.idusuario='.$_GET['id']);
		
		$template->SetParameter('nom',$datos['nombreusuario']);
		
		$roles=$query->getRows('*','rol','WHERE idrol!='.$datos['idrol']);
		$selectRol = '<select name="idroll"><option value="'.$datos['idrol'].'">'.$datos['label'].'</option>';
		foreach($roles as $key=>$valor){
			$selectRol .= '<option value="'.$valor['idrol'].'">'.$valor['label'].'</option>';
		}
		$selectRol .= '</select>';
		$template->SetParameter('rol',$selectRol);
		$template->SetParameter('acctionformulario','guardarRol&id='.$datos['idusuario']);
		return $template->Display();
	}
	
	/*
	*function incompletas sin uso 
	*/
	function guardarRol(){
		$query=new query;

		$update['idrol'] = $_POST[idroll];
		
		$query->dbUpdate($update,'usuario','WHERE idusuario='.$_GET[id]);

		echo "<script>window.location.href='registro.php?action=listaUsuario'</script>";	
	
	}
	
	function formMenu(){
		$template=new template;
		
		$template->SetTemplate('tpl/form_menu.html');
		
		return $template->Display();
	}
		
	function formUsuario(){
		$template = new template;
				
		$template->SetTemplate('tpl/form_usuario.html');
		$template -> SetParameter('acctionformulario','guardarUsuario');
				
		return $template->Display();
	}
	
	/*
	*function que guarda nuevo usuario si es que no se encuentra ya registrado
	*/
	function guardarUsuario(){
		$query=new query;
		$email=$query->getRows('*','usuario','WHERE EXISTS(select emailusuario from usuario where emailusuario="'.$_POST[emailUsuario].'")');
		
		if($query->getRows('*','usuario','WHERE EXISTS(select emailusuario from usuario where emailusuario="'.$_POST[emailUsuario].'")')){
			echo "<script>alert('Error, el email ya existe!!!');</script>";
			echo "<script>window.location.href='registro.php?action=formUsuario'</script>";
		}else{
		$insert['IDROL'] = 1;
		$insert['NOMBREUSUARIO'] = $_POST[nombreUsuario];
		$insert['EMAILUSUARIO'] = $_POST[emailUsuario];
		$insert['CUENTAUSUARIO'] = $_POST[cuentaUsuario]; 
		$insert['PASSWORD'] = md5($_POST[passwordUsuario]);
		
		$todoOK = true;
		$max_length = (1024*1024)*3;
		$upload = new upload; // upload
		$upload -> SetDirectory("uploads/imagen");
		$file = $_FILES['archivo']['name'];
		$insert['imagenusuario'] = "";
		if ($_FILES['archivo']['name'] != "")
		{
			$tipo_archivo = $_FILES['archivo']['type'];
			if (!(strpos($tipo_archivo, "jpeg"))) {
				$todoOK = false;
				echo "<script>alert('solo archivos jpg. Porfavor verifique e intente de nuevo, tipo: ".$tipo_archivo."');</script>";
			} else {
				$tamanio = $_FILES['archivo']['size'];
				if ($tamanio > $max_length) {
					$todoOK = false;
					echo "<script>alert('el archivo de imagen es demasiado grande');</script>";
				} else {
					$name = "imagen_".time();
					$upload -> SetFile("archivo");
					if ($upload -> UploadFile( $name )){
						$insert['imagenusuario'] = "uploads/imagen/".$name.".".$upload->ext;
					}
				}
			}
		}
		if($todoOK) {
			if($query->dbInsert($insert,"usuario")) { //save in the data base
				echo "<script>window.location.href='registro.php?action=formRespuesta'</script>";
			}else {
				echo "<script>alert('Error, no se registraron los datos');</script>";
			}
		}
		}
	}
	
	function formRespuesta(){
		$template = new template;
				
		$template->SetTemplate('tpl/form_registro_ok.html');
				
		return $template->Display();
	}
	
	function cuenta(){
		$template = new template;
		$template -> SetTemplate('tpl/form_cuenta.html');
		return $template->Display();
	}
	
	function opcion(){
		$template = new template;
		$template -> SetTemplate('tpl/form_opcion.html');
		return $template->Display();
	}
	
	function formOpcionUsuario(){
		$template = new template;
		$template->SetTemplate('tpl/form_opcion_usuario.html');
		return $template->Display();
	}
	
	/*
	*function que postea un comentario 
	*/
	function crearPizarron()
	{
		$template = new template;
		$query=new query;
		
		$band=$_POST[band];
		
		$recupera=$_POST[cargarImg];
		$usuario=$query->getRow('*','usuario','WHERE idusuario='.$_SESSION['idusuario']);
		$imagen = 'images/no_image.jpg';
				if($usuario['imagenusuario'] != null || $usuario['imagenusuario'] != ""){
					$imagen  = $usuario["imagenusuario"];
				}
				$imgTip = "<img src=\"images/jpg.php?name=../{$imagen}&amp;size=50\" alt=\"{$imagenusuario['nombreusuario']}\" />";
		
		$template->SetTemplate('tpl/crear_pizarron.html');
		$template->SetParameter('img',$imgTip);
		
		$buttonAdd = '<input type="button" value="Img" onclick="ajax(\'formImg\',\'registro.php?action=verFormImg\',\'\'); return false;" />';
		$template->SetParameter('imagen',$buttonAdd);
		
		/**************/
		$file='';
		if($band){
		/*****AQUI SE GUARDA LA IMAGEN ******/
			$todoOK = true;
			$max_length = (1024*1024)*3;
			$upload = new upload; // upload
			$upload -> SetDirectory("uploads/imagen");
			$file = $_FILES['img1']['name'];
			$insert['imagen'] = "";
			if ($_FILES['img1']['name'] != "")
			{
				$tipo_archivo = $_FILES['img1']['type'];
				if (!(strpos($tipo_archivo, "jpeg"))) {
					$todoOK = false;
					echo "<script>alert('solo archivos jpg. Porfavor verifique e intente de nuevo, tipo: ".$tipo_archivo."');</script>";
				} else {
					$tamanio = $_FILES['img1']['size'];
					if ($tamanio > $max_length) {
						$todoOK = false;
						echo "<script>alert('el archivo de imagen es demasiado grande');</script>";
					} else {
						$name = "imagen_".time();
						$upload -> SetFile("img1");
						if ($upload -> UploadFile( $name )){
							$insert['imagen'] = "uploads/imagen/".$name.".".$upload->ext;
							$query->dbInsert($insert,"imagenes");
						}
					}
				}
			}
			/*******************************/
			$imagen  = $name;	
			$file= $_POST['informacion'];	
			$file= stripslashes($file);
		
			$atrib = "width='150' height='100' alt='Short description of the image' ";
			$path = "uploads/imagen/$name.".$upload->ext; 
			$file.="<img src='$path' $atrib />";
			$template->SetParameter('informacion',$file);
		}
		$template->SetParameter('informacion',$file);
		
		/**************/
		
		/************LISTA DE PIZARRONES*******************/
		$informacion1=$query->getRows('*','pizarron p,usuario u','WHERE p.idusuario=u.idusuario and p.idusuario='.$_SESSION['idusuario'].' Order By p.idpizarron Desc');
		$informacion2=$query->getRows('*','pizarron p,usuario u','WHERE p.idusuario=u.idusuario and p.idusuario in (select idyo+""+idel-""-'.$_SESSION['idusuario'].' as idusuario from amigos where confirmacion="Si" and exists (select idyo+""+idel-""-'.$_SESSION['idusuario'].' as dato from amigos where idyo='.$_SESSION['idusuario'].' or idel='.$_SESSION['idusuario'].' )) Order By p.idpizarron Desc');
			
		/***********MI PIZARRON*****************************/
		$list1 ='<table>';
        if($informacion1 > 0) {
    
            foreach ($informacion1 as $key=>$value1) {
                
				$imagen1 = 'images/no_image.jpg';
				if($value1['imagenusuario'] != null || $value1['imagenusuario'] != ""){
					$imagen1  = $value1["imagenusuario"];
				}
				$imgTip1 = "<img src=\"images/jpg.php?name=../{$imagen1}&amp;size=55\" alt=\"{$imagenusuario['nombreusuario']}\" />";
				
				$list1 .= '<tbody><tr>
                  <td >'.$imgTip1.'</td>
                  <td ><strong>'.$value1["nombreusuario"].'</strong>
				  '.$value1["informacion"].'</td>
				  </tr>
				  <tr>
				   <td colspan="2" id="fecha">publicado el: '.$value1['fecha'].'</td>
				   <td id="boton" ><a href="registro.php?action=editarPizarron&amp;id='.$value1["idpizarron"].'">Editar</a></td>
				  </tr>
				  <tr>
				  <td colspan="3"><hr /></td>
                  </tr></tbody>';
            }
            $list1.='</table>';
	
        } else {
			$list1 = '<div>No se encontraron registros en la base de datos</div>';
		}
		
		$template->SetParameter('lista1',$list1);
		/**********PIZARRONES DE AMIGOS*********************/
		$list2 ='<table>';
        if($informacion2 > 0) {
    
            foreach ($informacion2 as $key=>$value2) {
                
				$imagen2 = 'images/no_image.jpg';
				if($value2['imagenusuario'] != null || $value2['imagenusuario'] != ""){
					$imagen2 = $value2["imagenusuario"];
				}
				$imgTip2 = "<img src=\"images/jpg.php?name=../{$imagen2}&amp;size=55\" alt=\"{$imagenusuario['nombreusuario']}\" />";
				
				$list2 .= '<tbody><tr>
                  <td >'.$imgTip2.'</td>
                  <td ><strong>'.$value2["nombreusuario"].'</strong>
				  '.$value2["informacion"].'</td>
				  </tr>
				  <tr>
				   
				   <td colspan="3" id="fecha" >publicado el: '.$value2['fecha'].'</td>
				   <!--td id="boton" ><a href="registro.php?action=editarPizarron&amp;id='.$value2[""].'">Editar</a></td-->
				  </tr>
				  <tr>
				  <td colspan="3"><hr /></td>
                  </tr></tbody>';
            }
            $list2.='</table>';
	
        } else {
			$list2 = '<div>No se encontraron registros en la base de datos</div>';
		}
		
		$template->SetParameter('lista2',$list2);
	
		$template->SetParameter('botonguardar','guardarPizarron');
		
		return $template->Display();
	}

	function guardarPizarron()
	{
		$query = new query;
		$fecha = date("d/m/Y h:i");
		$insert_pizarron['idusuario']=$_SESSION['idusuario'];
		$insert_pizarron['informacion']= $_POST[informacion];
		$insert_pizarron['fecha']= $fecha;
		
		if ($query->dbInsert($insert_pizarron,'pizarron')){
			echo "<script>alert('Se creo el PIZARRON con exito');</script>";
			echo "<script>window.location.href='registro.php?action=crearPizarron'</script>";
		}else{
			echo "<script>alert('Error, no creo el PIZARRON!!!');</script>";
			echo "<script>window.location.href='registro.php?action=crearPizarron'</script>";
			}
	}
	
	function verFormImg()
	{		
		$template = new template;
		$template -> SetTemplate('tpl/form_img.html');
		
		$template -> SetParameter('botonimg','crearPizarron');
		return "<div style=\"position: absolute; \">".$template->Display()."</div>";
				
	}
	
	function verFormImg2()
	{		
		$template = new template;
		
		$template -> SetTemplate('tpl/form_img.html');
		$template -> SetParameter('id',$_GET[id]);
		
		$template -> SetParameter('botonimg','editarPizarron&amp;id='.$_GET[id]);
		return "<div style=\"position: absolute; \">".$template->Display()."</div>";
				
	}
	
	function editarPizarron()
	{
		$template=new template;
		$query=new query;
		$template->SetTemplate('tpl/crear_pizarron.html');
		
		$informacion=$query->getRow('*','pizarron','WHERE idpizarron='.$_GET[id]);
		$usuario=$query->getRow('*','usuario','WHERE idusuario='.$informacion['idusuario']);
		
		$buttonAdd = '<input type="button" value="Img" onclick="ajax(\'formImg\',\'registro.php?action=verFormImg2&amp;id='.$_GET[id].'\',\'\'); return false;" />';
		$template->SetParameter('imagen',$buttonAdd);
		
		$imagen = 'images/no_image.jpg';
				if($usuario['imagenusuario'] != null || $usuario['imagenusuario'] != ""){
					$imagen  = $usuario["imagenusuario"];
				}
				$imgTip = "<img src=\"images/jpg.php?name=../{$imagen}&amp;size=50\" alt=\"{$imagenusuario['no	mbreusuario']}\" />";
	
		$template->SetParameter('informacion',$informacion['informacion'].$file);
		$template->SetParameter('img',$imgTip);
		$template->SetParameter('lista1','');
		$template->SetParameter('lista2','');
		
		$band=$_POST[band];
		if($band){
			/*****AQUI SE GUARDA LA IMAGEN ******/
			$todoOK = true;
			$max_length = (1024*1024)*3;
			$upload = new upload; // upload
			$upload -> SetDirectory("uploads/imagen");
			$file = $_FILES['img1']['name'];
			$insert['imagen'] = "";
			if ($_FILES['img1']['name'] != "")
			{
				$tipo_archivo = $_FILES['img1']['type'];
				if (!(strpos($tipo_archivo, "jpeg"))) {
					$todoOK = false;
					echo "<script>alert('solo archivos jpg. Porfavor verifique e intente de nuevo, tipo: ".$tipo_archivo."');</script>";
				} else {
					$tamanio = $_FILES['img1']['size'];
					if ($tamanio > $max_length) {
						$todoOK = false;
						echo "<script>alert('el archivo de imagen es demasiado grande');</script>";
					} else {
						$name = "imagen_".time();
						$upload -> SetFile("img1");
						if ($upload -> UploadFile( $name )){
							$insert['imagen'] = "uploads/imagen/".$name.".".$upload->ext;
							$query->dbInsert($insert,"imagenes");
						}
					}
				}
			}
			/*******************************/
			$imagen  = $name;	
			$file= $_POST['informacion'];	
			$file= stripslashes($file);
		
			$atrib = "width='150' height='100' alt='Short description of the image' ";
			$path = "uploads/imagen/$name.".$upload->ext; 
			$file.="<img src='$path' $atrib />";
			
			$template->SetParameter('informacion',$file);
		}
		$template->SetParameter('botonguardar','guardarEditarPizarron&amp;id='.$_GET[id]);
		return $template->Display();
	}
	
	function guardarEditarPizarron()
	{
		$query=new query;
		
		$updatePizarron['informacion']=$_POST[informacion];
		if ($query->dbUpdate($updatePizarron,'pizarron','WHERE idpizarron='.$_GET[id])){
			echo "<script>alert('Se Edito el PIZARRON con exito');</script>";
			echo "<script>window.location.href='registro.php?action=crearPizarron'</script>";
		}else{
			echo "<script>alert('Error, no creo el PIZARRON!!!');</script>";
			echo "<script>window.location.href='registro.php?action=crearPizarron'</script>";
			}
	}
	
	function mostrarPizarron()
	{
		$band=$_POST[band];
		
		$template=new template;
		$query=new query;
		$template->SetTemplate('tpl/pizarron.html');
		
		$file='';
		if($band){
		/*****AQUI SE GUARDA LA IMAGEN ******/
		$todoOK = true;
		$max_length = (1024*1024)*3;
		$upload = new upload; // upload
		$upload -> SetDirectory("uploads/imagen");
		$file = $_FILES['img1']['name'];
		$insert['imagen'] = "";
		if ($_FILES['img1']['name'] != "")
		{
			$tipo_archivo = $_FILES['img1']['type'];
			if (!(strpos($tipo_archivo, "jpeg"))) {
				$todoOK = false;
				echo "<script>alert('solo archivos jpg. Porfavor verifique e intente de nuevo, tipo: ".$tipo_archivo."');</script>";
			} else {
				$tamanio = $_FILES['img1']['size'];
				if ($tamanio > $max_length) {
					$todoOK = false;
					echo "<script>alert('el archivo de imagen es demasiado grande');</script>";
				} else {
					$name = "imagen_".time();
					$upload -> SetFile("img1");
					if ($upload -> UploadFile( $name )){
						$insert['imagen'] = "uploads/imagen/".$name.".".$upload->ext;
						$query->dbInsert($insert,"imagenes");
					}
				}
			}
		}	
		$file= $_POST[parrafo];		
		$file.='<img src="uploads/imagen/'.$name.'.'.$upload->ext.'"  width="150" height="100" alt="Short description of the image"/>';
			
				
		$template->SetParameter('datos',$file);
		}
		$template->SetParameter('datos',$file);

        $buttonAdd = '<input type="button" value="Img" onclick="ajax(\'formImg\',\'registro.php?action=verFormImg\',\'\'); return false;" />';
		$template->SetParameter('imagen',$buttonAdd);

		return $template->Display();
	}
	
	function solicitarAmistad()
	{
		$query=new query;
		
		$insertarAmigo['idyo']=$_SESSION['idusuario'];
		$insertarAmigo['idel']=$_GET[id];
		$insertarAmigo['confirmacion']='No';
		
		if($query->dbInsert($insertarAmigo,'amigos')){
			echo "<script>alert('Se envio la solitud!!!');</script>";
			echo "<script>window.location.href='index.php'</script>";
		}else{
			echo "<script>alert('NO se pudo enviar la solicitud');</script>";
			echo "<script>window.location.href='index.php'</script>";
		}
	}
	/*
	*function para confirmar o aceptar la solicitud de ver lo que posteo otro usuario 
	*/
	function confirmar()
	{
		$template=new template;
		$query=new query;
		
		$template->SetTemplate('tpl/confirmar.html');
		
		$lista=$query->getRows('*','amigos,usuario','WHERE idyo=idusuario and confirmacion="No" and idel='.$_SESSION['idusuario']);
		$count=count($lista);
		if($count>0){
		$list ='<table>';
    
            foreach ($lista as $key=>$value) {
                
				$imagen = 'images/no_image.jpg';
				if($value['imagenusuario'] != null || $value['imagenusuario'] != ""){
					$imagen  = $value["imagenusuario"];
				}
				$imgTip = "<img src=\"images/jpg.php?name=../{$imagen}&amp;size=55\" alt=\"{$imagenusuario['nombreusuario']}\" />";
				
				$list .= '<tbody><tr>
                  <td >'.$imgTip.'</td>
                  <td >'.$value['nombreusuario'].'</td>
				  <td ><a href="registro.php?action=guardarConfirmar&amp;conf=Si&amp;id='.$value["idamigos"].'">Aceptar</a></td>
				  <td ><a href="registro.php?action=guardarConfirmar&amp;conf=No&amp;id='.$value["idamigos"].'">Rechazar</a></td>
				  </tr></tbody>';
            }
            $list.='</table>';
		}else{
			$list='No tienes mas Solicitudes';		
			}
		$template->SetParameter('lista',$list);
		
		return $template->Display();
		
	}
	/*
	*function que guarda la solicitud aceptada
	*/
	function guardarConfirmar()
	{
		$query=new query;
		$decision=$_GET[conf];
		
		if($decision=='Si'){
		$updateAmigos['confirmacion']='Si';
		
		if ($query->dbUpdate($updateAmigos,'amigos','WHERE idamigos='.$_GET[id])){
			echo "<script>alert('Se confirmo con exito');</script>";
			echo "<script>window.location.href='registro.php?action=confirmar'</script>";
		}else{
			echo "<script>alert('Error, no creo el PIZARRON!!!');</script>";
			echo "<script>window.location.href='registro.php?action=crearPizarron'</script>";
			}
		}else{
			if($decision=='No'){
				if($query->dbDelete('amigos','WHERE idamigos='.$_GET[id])){
				echo "<script>alert('Se Rechazo la soliciutd');</script>";
				echo "<script>window.location.href='registro.php?action=confirmar'</script>";		
				}else{
					echo "<script>alert('Error, no creo el PIZARRON!!!');</script>";
					echo "<script>window.location.href='registro.php?action=crearPizarron'</script>";
					}
			}
		}	
	}	
	/*
	*function incompletas en prueba
	*/	
	function prueba()
	{
		$template=new template;
		
		$template->SetTemplate('tpl/prueba.html');
		
		
		$editar=$_POST['editar'];
		$template->SetParameter('editar',$editar);
		
		
		return $template->Display();
		
	}
	
	function prueba2()
	{
		$template=new template;
		
		$template->SetTemplate('tpl/muestra.html');
		
		$algo=stripslashes($_POST['elm1']);
		$template->SetParameter('algo',$algo);
		
		return $template->Display();		
	}
	
	function buscarUsuario()
	{
		$template=new template;
		
		$template->SetTemplate('tpl/buscarUsuario.html');
		$template->SetParameter('acctionformulario','listaUsuario');
	
		return $template->Display();
	}
	
	/*
	*function que devuelve la informacion o el perfil del usuario
	*/	
	function miPerfil()
	{
		$template=new template;
		$query=new query;
		
		$perfil=$query->getRow('*','usuario','WHERE idusuario='.$_SESSION['idusuario']);
		$template->SetTemplate('tpl/perfil.html');
			
		$template->SetParameter('nombreUsuario',$perfil['nombreusuario']);
		$template->SetParameter('emailUsuario',$perfil['emailusuario']);
		$imgTip = '<img src="'.$perfil['imagenusuario'].'"  width="70" height="50" alt="Short description of the image"/>';
		$imgTip = 'images/no_image.jpg';
				if($perfil['imagenusuario'] != null || $perfil['imagenusuario'] != ""){
					$imgTip = $perfil['imagenusuario'];
				}
				$imgTip = "<img src=\"images/jpg.php?name=../{$imgTip}&amp;size=55\" alt=\"{$imagenusuario['nombreusuario']}\" />";
		$template->SetParameter('imagenUsuario',$imgTip);
		
		$template->SetParameter('acctionformulario','editaPerfil');
		return $template->Display();
	}
	
	/*
	*function que carga la plantilla o formulario del usuario para ser editado 
	*/	
	function editaPerfil()
	{
		$template=new template;
		
		$template->SetTemplate('tpl/edita_perfil.html');
		
		$template->SetParameter('acctionformulario','guardaEditaPerfil');
		
		return $template->Display();
	}
	
	function guardaEditaPerfil()
	{
		$query=new query;
		
		$UpdatePerfil['nombreusuario']=$_POST['nombreUsuario'];
		$UpdatePerfil['password']=md5($_POST['passwordUsuario_n']);
		$confirma=$query->getRow('*','usuario','WHERE idusuario='.$_SESSION['idusuario']);
		$dir=$confirma['imagenusuario'];
		
		$todoOK = true;
		$max_length = (1024*1024)*3;
		$upload = new upload; // upload
		$upload -> SetDirectory("uploads/imagen");
		$file = $_FILES['archivo']['name'];
		$UpdatePerfil['imagenusuario'] = "";
		if ($_FILES['archivo']['name'] != "")
		{
			$tipo_archivo = $_FILES['archivo']['type'];
			if (!(strpos($tipo_archivo, "jpeg"))) {
				$todoOK = false;
				echo "<script>alert('solo archivos jpg. Porfavor verifique e intente de nuevo, tipo: ".$tipo_archivo."');</script>";
			} else {
				$tamanio = $_FILES['archivo']['size'];
				if ($tamanio > $max_length) {
					$todoOK = false;
					echo "<script>alert('el archivo de imagen es demasiado grande');</script>";
				} else {
					$name = "imagen_".time();
					$upload -> SetFile("archivo");
					if ($upload -> UploadFile( $name )){
						$UpdatePerfil['imagenusuario'] = "uploads/imagen/".$name.".".$upload->ext;
						if($confirma['imagenusuario']!=null){
						unlink($dir); 
						}
					}
				}
			}
		}
		
		if($confirma['password']==md5($_POST['passwordUsuario_a'])){
			if($todoOK) {
				if($query->dbUpdate($UpdatePerfil,"usuario","WHERE idusuario=".$_SESSION['idusuario'])) { //save in the data base
					echo "<script>window.location.href='registro.php?action=miPerfil'</script>";
				}else {
					echo "<script>alert('Error, no se registraron los datos');</script>";
				}
			}
		}else{
			echo "<script>alert('Error, no se registraron los datos');</script>";
			echo "<script>window.location.href='registro.php?action=editaPerfil'</script>";
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
		$template->SetParameter('sesion','');
		
		$template->SetParameter('menu',$this->formMenu());
		$template->SetParameter('login','');
		$template->SetParameter('usuario','');
		$template->SetParameter('amigos','');
		$template->SetParameter('calendario',$this -> calendario());
		
		$template->SetParameter('pizarron1','');
		
		if($_GET['action']=="formUsuario")
			$template->SetParameter('formulario',$this -> formUsuario());
			$template->SetParameter('pizarron','');
			$template->SetParameter('aviso','');
			
		if($_GET['action']=="formRespuesta")
			$template->SetParameter('formulario',$this -> formRespuesta());	
			
		if($_GET['action']=="listaUsuario")
			$template->SetParameter('formulario',$this -> listaUsuario());

		if($_GET['action']=="formEditarRol")
			$template->SetParameter('formulario',$this -> formEditarRol());	
		
		if($_GET['action']=="crearPizarron")
			$template->SetParameter('formulario',$this -> crearPizarron());
		
		if($_GET['action']=="editarPizarron")
			$template->SetParameter('formulario',$this -> editarPizarron());
		
		if($_GET['action']=="mostrarPizarron")
			$template->SetParameter('formulario',$this -> mostrarPizarron());	
			
		if($_GET['action']=="confirmar")
			$template->SetParameter('formulario',$this -> confirmar());	
			
		if($_GET['action']=="buscarUsuario")
			$template->SetParameter('formulario',$this -> buscarUsuario());

		if($_GET['action']=="prueba")
			$template->SetParameter('formulario',$this -> prueba());		
		
		if($_GET['action']=="miPerfil")
			$template->SetParameter('formulario',$this -> miPerfil());
		
		if($_GET['action']=="editaPerfil")
			$template->SetParameter('formulario',$this -> editaPerfil());
		
		if($_GET['action']=="prueba2")
			$template->SetParameter('formulario',$this -> prueba2());
		
		if($_SESSION['logeado'] == 1){
			if($_SESSION['idrol'] == 1){
				$template->SetParameter('login',$this->cuenta());
				$template->SetParameter('nombre',$_SESSION['nombreusuario']);
				$template->SetParameter('menu','');
				$template->SetParameter('aviso','');
				
				$template->SetParameter('pizarron',$this->formOpcionUsuario());				
				
			}else{
				$template->SetParameter('login',$this->cuenta());
				$template->SetParameter('nombre',$_SESSION['nombreusuario']);
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