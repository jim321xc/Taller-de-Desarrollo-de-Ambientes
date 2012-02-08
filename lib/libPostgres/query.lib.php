<?php
class query
{
 	var $query;
	
	function makequery($sql)
	{
		$enlace=pg_connect("dbname=flores host=localhost port=5432 user=postgres password=postgres" );
		$result = pg_query($enlace,$sql);
		
		unset($sql);
		return $result;
	}
	
	function getRows($type, $sql, $sql_sub = '') //recibe los valores a ser seleccionados, la tabla y las condiciones, retorna un array bidimensional con los resultados obtenidos
	{
		$sql2 = 'SELECT '.$type.' FROM '.$sql.' '.$sql_sub; 
		$row = array();
		$query = $this->makequery($sql2);
		while($temp = pg_fetch_assoc($query))
			$row[] = $temp;
		return $row;
	}
	
	function getRow($type, $sql, $sql_sub = '') // recibe los valores a ser seleccionados, la tabla y las condiciones, retorna un array unidimensional con el primer resultado obtenido
	{
		$sql2 = 'SELECT '.$type.' FROM '.$sql.' '.$sql_sub; 
		$query = $this->makequery($sql2);		
		$row = pg_fetch_assoc($query);
		return $row;
	}
	function numRow($type, $sql, $sql_sub = ''){
		$sql2 = 'SELECT '.$type.' FROM '.$sql.' '.$sql_sub; 
	
		$row = pg_num_rows($query);
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
			$sql .= ($cnt != $i) ? "$key," : "$key) VALUES (";
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
		return true;
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
			$sql .= ($cnt != $i) ? "$key = '$value', " : "$key = $val2 ";
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