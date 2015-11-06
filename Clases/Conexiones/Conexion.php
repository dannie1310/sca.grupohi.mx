<?php

function Conectar()
{	
	 if(!($linkC=mysql_connect("localhost","sca_puebla","PueblA_2013#")))
	 { 
		echo "Error al Conectar al Servidor . . .";
		exit();
	 }
	 if(!mysql_select_db("sca", $linkC))
	 {
		echo "Error al Conectar a la Base . . .";
		exit();
	 }
	 return $linkC;
}
?>
