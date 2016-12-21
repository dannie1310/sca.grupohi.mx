<?php
	session_start();
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition:  filename=Listado de Camiones '.date("d-m-Y").'_'.date("H.i.s",time()).'.cvs;');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Trebuchet MS;
}
.style5 {font-size: 12px;  }
.style6 {font-size: 14px}
.style7 {font-size: 10px}

-->
</style></head>

<body>
<?PHP 

    include("../../../../inc/php/conexiones/SCA.php");
	include("../../../../Clases/Funciones/Catalogos/Genericas.php");
  	$link=SCA::getConexion();
	$sql="SELECT c.*, 
          o.Nombre as Operador, 
          m.Descripcion as Marca, 
          case c.Estatus 
            when 0 then 'INACTIVO' 
            when 1 then 'ACTIVO' 
          end Estate,
          sin.Descripcion as Descripcion,
          bo.Identificador as Identificador
        FROM camiones as c
        LEFT JOIN operadores  AS o    ON o.IdOperador = c.IdOperador 
        LEFT JOIN marcas      AS m    ON m.IdMarca = c.IdMarca 
        LEFT JOIN sindicatos  AS sin  ON sin.IdSindicato = c.IdSindicato 
        LEFT JOIN botones     AS bo   ON bo.IdBoton = c.IdBoton 
        where c.IdProyecto = ".$_SESSION["Proyecto"]." 
        ORDER BY c.Estatus desc, Economico  ";
	$rs=$link->consultar($sql);
	$h=$link->affected();
	
	$contar="SELECT Estatus, count(Estatus) as cuantos from camiones where IdProyecto=".$_SESSION["Proyecto"]." group by Estatus";
	$rcontar=$link->consultar($contar);
	while($vcontar=mysql_fetch_array($rcontar))
	{
		if($vcontar[Estatus]==0)
			$i=$vcontar[cuantos];
		else
		if($vcontar[Estatus]==1)
			$a=$vcontar[cuantos];
		
	
	
	}
	
	

 ?>
<table width="845" align="center" border="0">
<tr>
  <td ><div align="right">
    <table width="845" align="center" border="0">
      <tr>
        <td colspan="16"><div align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></div></td>
      </tr>
      <tr>
        <td colspan="16">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="16"><span class="style6"><strong>RELACIÓN DE CAMIONES CON DISPOSITIVO ELECTRÓNICO ASIGNADO</strong></span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="16"><div align="left"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO:</font><font color="#666666" face="Trebuchet MS" style="font-size:12px;">&nbsp;<?php echo utf8_encode($_SESSION[NombreCortoProyecto]); ?></font></div></td>
      </tr>
      <tr>
        <td colspan="16"><div align="left"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">TOTAL DE CAMIONES:</font><font color="#666666" face="Trebuchet MS" style="font-size:12px;">&nbsp;<?php echo $h; ?></font></div></td>
      </tr>
      <tr>
        <td colspan="16"><div align="left"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">TOTAL DE CAMIONES ACTIVOS:</font><font color="#666666" face="Trebuchet MS" style="font-size:12px;">&nbsp;<?php echo $a; ?></font></div></td>
      </tr>
      <tr>
        <td colspan="16"><div align="left"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">TOTAL DE CAMIONES INACTIVOS:</font><font color="#666666" face="Trebuchet MS" style="font-size:12px;">&nbsp;<?php echo $i; ?></font></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td rowspan="2" valign="bottom" bgcolor="969696" class="style5"><div align="center" class="style9">
          <div align="center">#</div>
        </div></td>
        <td rowspan="2" valign="bottom" bgcolor="969696" class="style5"><div align="center" class="style9">
          <div align="center">ECONOMICO</div>
        </div></td>
        <td valign="bottom" bgcolor="969696" class="style5">&nbsp;</td>
        <td valign="bottom" bgcolor="969696" class="style5">&nbsp;</td>
        <td valign="bottom" bgcolor="969696" class="style5"><div align="center" >ANCHO</div></td>
        <td valign="bottom" bgcolor="969696" class="style5"><div align="center" >LARGO</div></td>
        <td valign="bottom" bgcolor="969696" class="style5"><div align="center" >ALTO</div></td>
        <td valign="bottom" bgcolor="969696" class="style5"><div align="center" >EXTENSIÓN</div></td>
        <td valign="bottom" bgcolor="969696" class="style5"><div align="center" >GATO</div></td>
        <td valign="bottom" bgcolor="969696" class="style5"><div align="center" >DISMINUCIÓN</div></td>
        <td valign="bottom" bgcolor="969696" class="style5"><div align="center" >CUBC.  PAGO</div></td>
        <td rowspan="2" valign="bottom" bgcolor="969696" class="style5"><div align="center" >PLACAS CAMIÓN</div></td>
        <td rowspan="2" valign="bottom" bgcolor="969696" class="style5"><div align="center" >PLACAS CAJA</div></td>
        <td rowspan="2" valign="bottom" bgcolor="969696" class="style5">MARCA</td>
        <td rowspan="2" valign="bottom" bgcolor="969696" class="style5">MODELO</td>
        <td rowspan="2" valign="bottom" bgcolor="969696" class="style5"><div align="center" >SINDICATO</div></td>
        <td rowspan="2" valign="bottom" bgcolor="969696" class="style5"><div align="center" >BOTÓN</div></td>
        <td rowspan="2" valign="bottom" bgcolor="969696" class="style5"><div align="center" >ESTATUS</div></td>
      </tr>
      <tr>
        <td align="center" valign="bottom" bgcolor="969696" class="style5">PROPIETARIO</td>
        <td align="center" valign="bottom" bgcolor="969696" class="style5">CHOFER</td>
        <td valign="bottom" bgcolor="969696" class="style5"><div align="center">(m)</div></td>
        <td valign="bottom" bgcolor="969696" class="style5"><div align="center">(m)</div></td>
        <td valign="bottom" bgcolor="969696" class="style5"><div align="center">(m)</div></td>
        <td valign="bottom" bgcolor="969696" class="style5"><div align="center">(m)</div></td>
        <td valign="bottom" bgcolor="969696" class="style5"><div align="center">(m<sup>3</sup>)</div></td>
        <td valign="bottom" bgcolor="969696" class="style5"><div align="center">(m<sup>3</sup>)</div></td>
        <td valign="bottom" bgcolor="969696" class="style5"><div align="center">(m<sup>3</sup>)</div></td>
      </tr>
      <?php

	$i=1;
	while($v=mysql_fetch_array($rs))
	{

   ?>
      <tr>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><div align="center"><span class="style7"><?php echo $i; ?></span></div></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><div align="center"><span class="style7"><?php echo $v[Economico]; ?></span></div></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><span class="style7"><?php echo utf8_encode($v["Propietario"]); ?></span></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><span class="style7"><?php echo utf8_encode($v["Operador"]); ?></span></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><div align="right"><span class="style7"><?php echo $v[Ancho]; ?></span></div></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><div align="right"><span class="style7"><?php echo $v[Largo]; ?></span></div></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><div align="right"><span class="style7"><?php echo $v[Alto]; ?></span></div></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><div align="right"><span class="style7"><?php echo $v[AlturaExtension]; ?></span></div></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><div align="right"><span class="style7"><?php echo $v[EspacioDeGato]; ?></span></div></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><div align="right"><span class="style7"><?php echo $v[disminucion]; ?></span></div></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><div align="right"><span class="style7"><?php echo $v[CubicacionParaPago]; ?></span></div></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><div align="center"><span class="style7"><?php echo $v[Placas]; ?></span></div></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><div align="center"><span class="style7"><?php echo $v[PlacasCaja]; ?></span></div></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><span class="style7"><?php echo $v["Marca"]; ?></span></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><span class="style7"><?php echo $v["Modelo"]; ?></span></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><span class="style7"><?php echo $v["Descripcion"]; ?></span></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><div align="center"><span class="style7">&nbsp;<?php echo $v["Identificador"]; ?></span></div></td>
        <td <?php $a=$i%2; if($a==0) echo "bgcolor='C0C0C0'";  ?>><div align="center"><span class="style7"><?php echo $v[Estate]; ?></span></div></td>
      </tr>
      <?PHP $i++;} ?>
    </table>
    <span class="style7"></span></div></td>
</tr>
</table>
</body>
</html>
