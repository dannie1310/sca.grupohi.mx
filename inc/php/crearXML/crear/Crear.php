<?php

  include("../conexiones/conexion.php");
  
  $link = SCA::getConexion();
  $sql = "select * from tac_empleados_vw;";
  $result = mssql_query($sql);
  mssql_close($link);
  
  
  if(!$fp=fopen("00001.xml","w+"))
  {
  	echo "No se ha podido abrir el fichero";
  }
  else
  {
		/*Escribo la cabecera del xml
		Véase que \r (retorno de carro) en octal es 015 y \n (nueva linea) en octal es 012*/
	
		
		fwrite($fp,"<?xml version=\"1.0\"  encoding=\"UTF-8\" ?>\012");
		fwrite($fp,"<Empleados>\012");
		
		
		while($row = mssql_fetch_array($result))
		{
			/*estructura del nodo*/
			
			#fwrite($fp,"Hola");
	
			fwrite($fp,"  <Empleado>\012");
			fwrite($fp,"    <Proyecto>".$row[0]."</Proyecto>\012");
			fwrite($fp,"    <Nombre>".$row[1]."</Nombre>\012");
			fwrite($fp,"    <ApellidoP>".$row[2]."</ApellidoP>\012");
			fwrite($fp,"    <ApellidoM>".$row[3]."</ApellidoM>\012");
			fwrite($fp,"    <Categoria>".$row[6]."</Categoria>\012");
			fwrite($fp,"    <NSS>".$row[5]."</NSS>\012");
			fwrite($fp,"    <NumEmpleado>".$row[4]."</NumEmpleado>\012");
			fwrite($fp,"  </Empleado>\012");
		}
		
		fwrite($fp,"</Empleados>");
		
		if(!fclose($fp)) 
		{
			echo "No se ha podido cerrar el fichero";
		}
	}
  
  

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Crear XML File</title>
</head>

<body>
</body>
</html>