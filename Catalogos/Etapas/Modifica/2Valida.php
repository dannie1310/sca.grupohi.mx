<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
	session_start();
	
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
</head>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script src="../../../Clases/Js/Cajas.js" >
</script>
<script>
function valida()
{

	if(document.frm.descripcion.value=="")
	{
		alert("INDIQUE LA DESCRIPCIÓN DEL MATERIAL");
		document.frm.descripcion.focus();
		return false;
	}else
	return true;
}
</script>
<?php
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
$etapa=$_REQUEST[etapa];
//echo $etapa;
$link=SCA::getConexion();

 ?>
<body>
<table align="center" width="600" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Etapas.gif" width="16" height="16" />SCA.- Edici&oacute;n de Etapas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
</table>

<form action="3Valida.php" method="post" name="frm">
<table width="845" align="center" border="0">
  <tr >
    <td class="Subtitulo">DATOS DE LA ETAPA SELECCIONADA</td>
  </tr>
</table>

<table width="233" border="0" align="center">
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td width="102" class="EncabezadoTabla">ESTATUS</td>
  </tr>
  <?php
 $sql="SELECT * FROM etapasproyectos where IdEtapaProyecto=".$etapa." ;";

	//echo $sql;
  $result=$link->consultar($sql);
 $row=mysql_fetch_array($result);
  
  
   ?>
  <tr>
    <td colspan="4"> <div align="center" class="texto"></div>  <input name="descripcion" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')"  value="<?php echo $row[Descripcion]; ?>" size="30" maxlength="50"></td>
    <td width="102"><div align="center">
      <select name="estatus">
            <option value="0" <?PHP if($row[Estatus]==0) echo "selected"; ?>>INACTIVO</option>
            <option value="1" <?PHP if($row[Estatus]==1) echo "selected"; ?>>ACTIVO</option>
        </select>
    </div></td>
  </tr>
  <tr>
    <td width="71">&nbsp;</td>
    <td width="190">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><div align="right">
          <input name="Submit2" type="button" class="boton" onClick="history.go(-1)" value="Regresar" />
    </div></td>
    <td><div align="right">
      <input type="hidden" name="etapa" value="<?php echo $etapa; ?>">
      <input name="Submit" type="button" class="boton" onClick="if(valida())document.frm.submit()" value="Modificar">
    </div></td>
  </tr>
</table>
</form>

</body>
</html>
