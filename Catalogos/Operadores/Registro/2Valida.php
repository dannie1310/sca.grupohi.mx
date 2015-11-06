<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
</head>
<body>
<table align="center" width="800" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Member.gif" width="16" height="16" />&nbsp;SCA.- Registro de Operadores</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
session_start();
$IdProyecto=$_SESSION['Proyecto'];
$nombre=strtoupper($_REQUEST[nombre]);
$direccion=strtoupper($_REQUEST[direccion]);
$licencia=strtoupper($_REQUEST[licencia]);
$vigencia=$_REQUEST[vigencia];

$partesdes=explode(" ",$nombre);
$how=sizeof($partesdes);

$like="";
for($i=0;$i<$how;$i++)
{	
	if($partesdes[$i]!=" ")
	{
		//echo $i.'-'.$how.'<br>';
		if($i<($how-1))
			{
				$like=$like."nombre like '%$partesdes[$i]%' or ";
			}
		else
			{
				$like=$like."nombre like '%$partesdes[$i]%'";
			}
	}
}


$link=SCA::getConexion();
$sql="SELECT *, case Estatus
when 0 then 'INACTIVO'
when 1 then 'ACTIVO'
end Estate
 FROM operadores where IdProyecto=$IdProyecto and $like;";
$res=$link->consultar($sql);
//echo $sql;
$cantidad=$link->affected();
//echo $cantidad;
if($cantidad>=1){
?>

<form action="3Registra.php" method="post" name="frm">
<table width="600" border="0" align="center">
  <tr>
    <td colspan="3" class="Subtitulo">VERIFIQUE QUE EL OPERADOR QUE DESEA REGISTRAR, NO HAYA SIDO REGISTRADO PREVIAMENTE </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td class="EncabezadoTabla">NOMBRE</td>
      <td width="290" class="EncabezadoTabla">DIRECCI&Oacute;N</td>
      <td width="71" class="EncabezadoTabla">ESTATUS</td>
    </tr>
	<?PHP
	
	$pr=1;
	 while($v=mysql_fetch_array($res)) 
	 { ?>
    <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td width="225"><?PHP echo $v[Nombre]; ?></td>
    <td><?PHP echo $v[Direccion]; ?></td>
    <td>
      <div align="center"><?PHP echo $v[Estate]; ?></div></td>
    </tr>
  <?PHP $pr++; } ?>
  <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
</table>

<table width="600" border="0" align="center">
  <tr>
    <td colspan="4" class="Subtitulo">SI EL OPERADOR QUE DESEA REGISTRAR NO COINCIDE CON ALGUNO DE LOS ANTERIORES, VERIFIQUE QUE LOS DATOS A REGISTRAR SEAN CORRECTOS. </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="367">&nbsp;</td>
    <td width="145" class="Concepto">FECHA DE REGISTRO: </td>
    <td width="74" colspan="2" class="Item1"><?PHP echo date("d-m-Y"); ?>
        <input type="hidden" name="fecha" value="<?PHP echo date("Y-m-d"); ?>" /></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td width="112" class="Concepto">NOMBRE:</td>
    <td colspan="3" class="Item1"><?php echo $nombre; ?>&nbsp;
	
	  <input type="hidden" name="nombre" value="<?php echo $nombre; ?>" /></td>
  </tr>
  <tr>
    <td class="ConceptoTop">DIRECCI&Oacute;N:</td>
    <td colspan="3" class="Item1"><?php echo $direccion; ?>&nbsp;
      <input type="hidden" value="<?php echo $direccion; ?>" name="direccion" /></td>
  </tr>
  <tr>
    <td class="Concepto">No. LICENCIA: </td>
    <td width="174" class="Item1"><?php if ($licencia=='') echo " - - - - - - - - - - "; else echo $licencia; ?>&nbsp;
      <input type="hidden" name="licencia" value="<?php echo $licencia; ?>" /></td>
    <td width="70" class="Concepto">VIGENCIA:</td>
    <td width="226" class="Item1"><?php echo $vigencia; ?>&nbsp;
      <input type="hidden" name="vigencia" value="<?php echo $vigencia; ?>" /></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="107">&nbsp;</td>
    <td width="175">&nbsp;</td>
    <td width="174"><div align="right">
      <input name="Submit" type="button" class="boton" onclick="history.go(-1)" value="Modificar" />
    </div></td>
    <td width="116"><div align="right">
      <input name="Submit2" type="submit" class="boton" value="Registrar"  />
    </div></td>
  </tr>
</table>

</form>
<?PHP } else { ?>

<form action="3Registra.php" method="post" name="frm">
<table width="600" border="0" align="center">
  <tr>
    <td colspan="4" class="Subtitulo">VERIFIQUE QUE LOS DATOS A REGISTRAR SEAN CORRECTOS </td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
    <td width="366">&nbsp;</td>
    <td width="144" class="Concepto">FECHA DE REGISTRO: </td>
    <td width="76" colspan="2" class="Item1"><?PHP echo date("d-m-Y"); ?>
    <input type="hidden" name="fecha" value="<?PHP echo date("Y-m-d"); ?>" /></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
</table>

<table width="600" border="0" align="center">
  
  <tr>
    <td width="112" class="Concepto">NOMBRE:</td>
    <td colspan="3" class="Item1"><?php echo $nombre; ?>&nbsp;
      <input type="hidden" name="nombre" value="<?PHP echo $nombre; ?>" /></td>
  </tr>
  <tr>
    <td class="ConceptoTop">DIRECCI&Oacute;N:</td>
    <td colspan="3" class="Item1"><?php echo $direccion; ?>&nbsp;
      <input type="hidden" name="direccion" value="<?PHP echo $direccion; ?>" /></td>
  </tr>
  <tr>
    <td class="Concepto">No. LICENCIA: </td>
    <td width="174" class="Item1"><?php if ($licencia=='') echo " - - - - - - - - - - "; else echo $licencia; ?>&nbsp;
      <input type="hidden" name="licencia" value="<?PHP echo $licencia; ?>" /></td>
    <td width="73" class="Concepto">VIGENCIA:</td>
    <td width="223" class="Item1"><?php echo $vigencia; ?>&nbsp;
      <input type="hidden" name="vigencia" value="<?PHP echo $vigencia; ?>" /></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="107">&nbsp;</td>
    <td width="175">&nbsp;</td>
    <td width="174"><div align="right">
      <input name="Submit" type="button" class="boton" onclick="history.go(-1)" value="Modificar" />
    </div></td>
    <td width="116"><div align="right">
      <input name="Submit2" type="submit" class="boton" value="Registrar"  />
    </div></td>
  </tr>
</table>

</form>

<?PHP } 
$link->cerrar();
?>

</body>
</html>
