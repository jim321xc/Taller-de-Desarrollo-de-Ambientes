<?php
class query
{
 	var $query;
	
	function makequery($sql)
	{
		$result = mysql_query($sql);
		if(mysql_error())
		{
			echo '<center>';
			echo '<div style="border: 1px solid #0253b8; font: 12px verdana; width: 700px; margin: 0 auto; color: #0253b8; background-color: #EFEFEF; clear: both;">';
			echo "<div style=\"border-bottom: 1px solid #0253b8; padding: 10px;\" align=\"left\"><strong>Error:</strong><br>".mysql_error()."</div>";
			echo "<div style=\"background-color: #EAEAEA; padding: 10px;\" align=\"left\">{$sql}</div>";
			echo '</div>';
			echo '</center>';			
			exit();
		}
		unset($sql);
		return $result;
	}
	
	function getRows($type, $sql, $sql_sub = '') //recibe los valores a ser seleccionados, la tabla y las condiciones, retorna un array bidimensional con los resultados obtenidos
	{
		$sql2 = 'SELECT '.$type.' FROM '.$sql.' '.$sql_sub; 
		$row = array();
		$query = $this->makequery($sql2);
		while($temp = mysql_fetch_assoc($query))
			$row[] = $temp;
		return $row;
	}
	
	function getRow($type, $sql, $sql_sub = '') // recibe los valores a ser seleccionados, la tabla y las condiciones, retorna un array unidimensional con el primer resultado obtenido
	{
		$sql2 = 'SELECT '.$type.' FROM '.$sql.' '.$sql_sub; 
		$query = $this->makequery($sql2);		
		$row = mysql_fetch_assoc($query);
		return $row;
	}
	
	function dbInsert($insert,$table) //recibe un array con los valores a ser insertados y el nombre de la tabla, retorna el indice de insercion.
	{
		$cnt = count($insert);
		$sql = "INSERT INTO ".$table." (";
		$i = 0;
		foreach($insert as $key => $value)
		{
			$i++;
			$sql .= ($cnt != $i) ? "`$key`," : "`$key`) VALUES (";
		}
		$i = 0;
		foreach($insert as $key=>$value)
		{
			$i++;
			if($value == "NOW()")
				$val2 = "NOW()";
			else
				$val2 = "'{$value}'";
			$sql .= ($cnt != $i) ? "'{$value}', " : "$val2)";
		}
		$this->makequery($sql);
		return intval(mysql_insert_id());
	}
	
	function dbUpdate($update,$table,$sql_sub = '') //recibe un array con los valores a ser actualizados, el nombre de la tabla y las condiciones
	{
		$cnt = count($update);
		$sql = "UPDATE ".$table." SET ";
		$i = 0;
		foreach($update as $key => $value)
		{
			$i++;
			if($value == "NOW()")
				$val2 = "NOW()";
			else
				$val2 = "'{$value}'";
			$sql .= ($cnt != $i) ? "`$key` = '$value', " : "`$key` = $val2 ";
		}
		$sql .= $sql_sub;
		$this->makequery($sql);
		return true;
	}
	
	function dbDelete($table,$sql_sub) //recibe el nombre de la tabla y las condiciones
	{
		$sql = "DELETE FROM ".$table." ".$sql_sub;
		$this->makequery($sql);
		return true;
	}
	
}
?>