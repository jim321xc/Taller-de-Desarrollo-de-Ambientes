<?php

/*
*class que carga las plantillas de opciones
*/
class opciones
{
	function formLogin(){
		$template=new template;
		
		$template->SetTemplate('tpl/form_login.html');
		$template->SetParameter('acctionformulario','validarUsuario');
		
		return $template->Display();
	}
	function formMenu(){
		$template=new template;
		
		$template->SetTemplate('tpl/form_menu.html');
		
		return $template->Display();
	}
	
	function salir()
	{
		session_destroy();
		echo "<script>window.location.href='index.php'</script>";
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
		/*****************/
		
		$calendario=$tabla;
		$template->SetParameter('opciones',$calendario);
		
		return $template->Display();
	}
	
	/*
	*function que indexa al html 
	*/
	function Display()
	{
		$template = new template;
		$template->SetTemplate('tpl/index.html'); 
		$template->SetParameter('Keywords','php, sample, structure');
		$template->SetParameter('sesion','');
		$template->SetParameter('login','');
		$template->SetParameter('usuario','');
		$template->SetParameter('menu',$this->formMenu());
		$template->SetParameter('pizarron','');
		$template->SetParameter('aviso','');
		$template->SetParameter('calendario',$this -> calendario());	
		
		if($_GET['action']=="formLogin")
			$template->SetParameter('formulario',$this -> formLogin());
		
		return $template->Display();
	}
}
?>