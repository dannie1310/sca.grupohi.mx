<?php
    /*
			24/11/2010
			By Omar Aguayo	
		
		Función para Conectarnos a una Servidor de SQL SERVER y a una base de Datos
    */	
			  
    	function SCA::getConexion(){
			if(!($link=mssql_connect("192.168.103.153", "sa", "saocadeco"))){ 
				echo "<center><strong>No se puede Establecer Conexi&oacute;n con el Servidor</strong></center>";
				exit();
			}
			
			if(!mssql_select_db("TAC", $link)){
        echo "<center><strong>No se puede Establecer Conexi&oacute;n con la Base de Datos</center></strong>";
        exit();
			}
		
			return $link;
		}
?>
