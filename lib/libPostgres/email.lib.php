<?php

class email
{
	function email($from, $subject, $message, $to) //recives strings, 1: adress from where te mail was dispatched, 2: subject, 3: message an html page, 4: the address to send the mail
	{
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "Content-Transfer-Encoding: 7bit\n";
		$headers .= "From: ".$from."\n";
		return mail($to, $subject, $message , $headers); 
	}
	
	function generateCode($int) //recives the number of characters to generateCode
	{
		$string_a = array("A","B","C","D","E","F","G","H","J","K","L","M","N","P","R","S","T","U","V","W","X","Y","Z","2","3","4","5","6","7","8","9");
		$keys = array_rand($string_a, $int);
		foreach($keys as $n => $v)
		{
   		$string .= $string_a[$v];
		}
		return $string;
	}
}

?>