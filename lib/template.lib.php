<?php
class template
{
	var $parameter = array();
	var $template;
	var $html;
	
	function SetTemplate($template) //define el template a ser usado
	{
		$this->template = $template;
		return true;
	}
	
	function SetParameter($variable,$value) //almacena un parametro de nombre $variable y valor $value para ser reemplazado en el template, si se trata de un array se almacenarán los valores del array separados por comas. Retorna true
	{
		if(is_array($value))
		{
			$variable2 = '';
			foreach($value as $key => $val)
				$variable2 .= $val.', ';
			$this->parameter[$variable] = $variable2;
		}
		else
			$this->parameter[$variable] = $value;
		return true;
	}
	
	function Display() //retorna el html resultante de hacer los reemplazos fijados por SetParameter en el template especificado.
	{
		$this->html = implode("",file($this->template));
		foreach($this->parameter as $key => $value)
		{
			$temp = '['.$key.']';
			$this->html = str_replace($temp,$value,$this->html);
		}
		return $this->html;
	}
}
?>