<?php
include("../../../inc/php/conexiones/SCA.php"); 
session_start();
$link=SCA::getConexion();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
	//session_start();
	
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="600" align="center"  align="center">
      <tr>
        <td class="EncabezadoPagina">
        	<img src="../../../Imgs/16-user.gif" width="16" height="16" />&nbsp;SCA.- Asignación de Permisos
        </td>
      </tr>
      <tr>
        <td>&nbsp;
        	
        </td>
      </tr>
</table>
<table width="600" align="center" class="text">
	<tr>
    	<td>
        Por favor, selecciona el usuario al que desees agregar permisos
        </td>
    </tr>
    <tr>
    	<td>
        &nbsp;
        </td>
    </tr>
	<tr>
    	<td>
<?php
echo"
<select name=combo id='combo' size=1 onChange='usuario();'>";
    $query = mysql_query("SELECT * FROM usuarios ORDER BY Descripcion"); 
    echo "<option value=0 >Seleccione un Usuario...</option>";
        while($row = mysql_fetch_array($query))
            {
             echo"<option value=$row[IdUsuario]>$row[Descripcion]</option>";
            }
        echo"</select>";
?>
		</td>
	</tr>
</table>
<table width="600" align="center">
	<tr>
    	<td>	
<div id="permisos">
</div>
<div id="aviso">
</div>
		</td>
    </tr>
</table>
<script type="text/javascript" src="../../../inc/js/ajax.js"></script>