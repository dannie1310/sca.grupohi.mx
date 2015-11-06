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
<script type="text/javascript" src="../../../Clases/Js/Cajas.js" ></script>
<script>
function valida(id)
{
if (!document.getElementById) return false;
  formulario = document.getElementById(id);
 
  if(formulario.tolerancia)
{	
	if((formulario.tolerancia.value==".")||(formulario.tolerancia.value==""))
	formulario.tolerancia.value="0.00";
	
}
  if(formulario.minimo)
{	
	if((formulario.minimo.value!=".")&&(formulario.minimo.value!=""))
		{ 
			an=formulario.minimo.value;
			ancho=parseFloat(an);
			//alert(ancho);
			if(ancho<=0)
			{
				alert("POR FAVOR INDIQUE EL TIEMPO MÍNIMO");
				formulario.minimo.focus();
				return false;
			}
			else
		{ 
		   return true;
		}
		}
		else
		if((formulario.minimo.value==".")||(formulario.minimo.value==""))
		{
				alert("POR FAVOR INDIQUE EL TIEMPO MÍNIMO");
				formulario.minimo.focus();
				return false;
		}
		else
		{ 
		   return true;
		}
		
}
 } 
</script>
<?php
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
$cronometria=$_REQUEST[cronometria];
$ruta=$_REQUEST[ruta];
$link=SCA::getConexion();
$verifica="select a.Estatus as er, b.Estatus as eo, c.Estatus as et from rutas as a, origenes as b, tiros as c where a.IdRuta=".$ruta." and b.IdOrigen=a.IdOrigen and c.IdTiro=a.IdTiro";
$res=$link->consultar($verifica);
$ves=mysql_fetch_array($res);
if($ves[er]==0||$ves[eo]==0||$ves[et]==0)
$bloquea=1;
 ?>
<body>
<table align="center" width="800" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Clock.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Cronometrias </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<form action="3Valida.php" method="post" name="frm">
<table width="845" align="center" border="0">
  <tr >
    <td class="Subtitulo">DATOS DE LA CRONOMETRIA SELECCIONADA </td>
  </tr>
</table>

<table width="400" border="0" align="center">
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="EncabezadoTabla">ID RUTA </td>
    <td width="260" class="EncabezadoTabla">TIEMPO M&Iacute;NIMO </td>
    <td width="135" class="EncabezadoTabla">TOLERANCIA</td>
    <td width="82" class="EncabezadoTabla">ESTATUS</td>
  </tr>
  <?php
 $sql="SELECT * FROM cronometrias where IdCronometria=".$cronometria." ;";

	//echo $sql;
  $result=$link->consultar($sql);
 $row=mysql_fetch_array($result);
  
  
   ?>
  <tr>
    <td colspan="2"> <div align="center" class="texto"><?php echo $row[IdRuta];   ?></div></td>
    <td width="260" align="center" class="texto"><input name="minimo" id="minimo" type="text" class="text" style="text-transform:uppercase;text-align:right" onKeyPress="onlyDigits(event,'decOK')"  value="<?php echo $row[TiempoMinimo]; ?>" size="10" maxlength="10"> 
    min. </td>
    <td width="135" align="center" class="texto"><input name="tolerancia" id="tolerancia" type="text" class="text" style="text-transform:uppercase;text-align:right" onKeyPress="onlyDigits(event,'decOK')"  value="<?php echo $row[Tolerancia]; ?>" size="10" maxlength="10"> 
    min.  </td>
    <td width="82"><div align="center">
      <select name="estatus" >
            <option value="0" <?PHP if($row[Estatus]==0) echo "selected"; ?>>INACTIVO</option>
            <?php if($bloquea!=1){?><option value="1" <?PHP if($row[Estatus]==1) echo "selected"; ?>>ACTIVO</option><?php }?>
        </select>
    </div></td>
  </tr>
  <tr>
    <td width="20">&nbsp;</td>
    <td width="61">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><div align="right">
        <input name="Submit2" type="button" class="boton" onClick="history.go(-1)" value="Regresar" />
    </div></td>
    <td><div align="right">
      <input type="hidden" name="cronometria" value="<?php echo $cronometria; ?>">
	   <input type="hidden" name="ruta" value="<?php echo $ruta; ?>">
      <input name="Submit" type="button" class="boton" onClick="if(valida('frm'))document.frm.submit()" value="Modificar">
    </div></td>
  </tr>
</table>
</form>

</body>
</html>
