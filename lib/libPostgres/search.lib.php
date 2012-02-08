<?php
class search
{

	function composesearch($str,$values,$dispechos=false)
	{
		$str = str_replace ('+'," + ",$str);
		$str = str_replace ('  '," ",$str);
		$str = str_replace ('\"','"',$str);
		$flag=false;
		$otherflag = false;
		$returnstring = "WHERE ";
		$tempstring = "";
		$glue = " OR";
		$strings = explode(" ",$str);
		for($i=0; $i < count($strings); $i++)
		{
			if ($strings[$i] == "+")
				$glue = " AND";
			elseif($flag)
			{
				$tempstring .= " ".$strings[$i];
				if ((strrpos($strings[$i],'"') == strlen($strings[$i]) - 1) || ($i == count($strings) - 1))	//found " at the end of this string, send the whole string to code or the string is the last one to be procesed, meaning the close quote was not present.
				{
					$flag=false;
					$tempstring = substr($tempstring,1,strlen($tempstring) - 2); //remove the " at the begining and end
					if ($otherflag) $returnstring .= $glue;
					$glue = " OR";
					$returnstring .= " (";
					$returnstring .= $this->abnormalsearch($tempstring,$values,$dispechos);
					$otherflag = true;
					$returnstring .= ")";
				}
			}
			elseif (strpos($strings[$i],'"') === 0) //there's only 1 " in the string, we have to assemble the whole string
			{
				if (strrpos($strings[$i],'"') == strlen($strings[$i]) - 1) //if the string is "value" remove quotes
				{
					if ($otherflag) $returnstring .= $glue;
					$glue = " OR";
					$strings[$i] = substr($strings[$i],1,strlen($strings[$i]) - 2);
					$returnstring .= " (";
					$returnstring .= $this->normalsearch($strings[$i],$values,$dispechos);
					$otherflag = true;
					$returnstring .= ")";
				}
				else
				{
					$tempstring = $strings[$i];
					$flag = true;
				}
			}
			else
			{
				if ($otherflag) $returnstring .= $glue;
				$glue = " OR";
				$returnstring .= " (";
				$returnstring .= $this->normalsearch($strings[$i],$values,$dispechos);
				$otherflag = true;
				$returnstring .= ")";
			}
		}
		return $returnstring;
	}

	function normalsearch($str,$values,$dispechos=false)
	{
		$return = "";
		$a = strpos($str,'*');
		$flag = false;
		if ($a === 0) //la cadena de busqueda es tipo *valor
		{
			if ($dispechos)
				echo "String has *value<br>";
			foreach($values as $val)
			{
				if ($flag)
					$return .= " OR ";
				$return .= "$val LIKE \"%".substr($str,1)."\"";
				$flag = true;
			}
		}
		elseif ($a == (strlen($str) - 1)) //la cadena es de tipo valor*
		{
			if ($dispechos)
				echo "String has value*<br>";
			foreach($values as $val)
			{
				if ($flag)
					$return .= " OR ";
					$return .= "$val LIKE \"".substr($str,0,(strlen($str) - 1))."%\"";
				$flag = true;
			}
		}
		else //la cadena es de tipo valor
		{
			if ($dispechos)
				echo "String has value<br>";
			foreach($values as $val)
			{
				if ($flag)
					$return .= " OR ";
				$return .= "$val LIKE \"%".$str."%\"";
				$flag = true;
			}
		}
		return $return;
	}

	function abnormalsearch($str,$values,$dispechos)
	{
		$return = "";
		foreach($values as $val)
		{
			if ($flag)
				$return .= " OR ";
			$return .= "$val LIKE \"%".$str."\"";
			$flag = true;
		}
		foreach($values as $val)
		{
			if ($flag)
				$return .= " OR ";
				$return .= "$val LIKE \"".$str."%\"";
			$flag = true;
		}
		foreach($values as $val)
		{
			if ($flag)
				$return .= " OR ";
			$return .= "$val LIKE \"% ".$str."% \"";
			$flag = true;
		}
		return $return;
	}
}

?>
