<?php 
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
$IdMaquina=$_REQUEST["IdMaquina"];
$link=SCA::getConexion();
$sql="select * from maquinaria where IdMaquinaria=".$IdMaquina."";
$r=$link->consultar($sql);
$v=mysql_fetch_array($r);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SCA.-Registro de Maquinaria</title>

<link rel="stylesheet" type="text/css" media="all" href="../../../Clases/Calendario/calendar-blue2.css" title="win2k-cold-1" />
<script type="text/javascript" src="../../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../../Clases/Js/Cajas.js"></script>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>


<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
</head>

<body>

<form name="frm" id="frm" method="post" action="3Registra.php" onSubmit="return valida(this.id)" target="registro">
<table width="500" border="0" align="center">
  <tr>
    <td align="center" class="Concepto">Arrendador</td>
    <td colspan="2" align="center" class="Concepto">Tipo de Equipo</td>
    <td align="center" class="Concepto">Origen</td>
  </tr>
  
  <tr class="Item1">
    <td align="center" ><?php comboSelected("maquinaria_arrendadores","NombreCorto","IdArrendador",$v["IdArrendador"])?></td>
    <td colspan="2" align="center" ><?php comboSelected("maquinaria_tipos","Descripcion","IdTipo",$v["IdTipo"])?></td>
    <td align="center" ><?php comboSelected("maquinaria_relacion","Descripcion","IdRelacion",$v["IdTipoRelacion"])?></td>
  </tr>
   <tr class="Concepto" >
     <td align="center" >Marca</td>
     <td colspan="2" align="center" >Modelo</td>
     <td align="center" >Serie</td>
   </tr>
   <tr class="Item1" >
     <td align="center" ><input name="marca" type="text" class="Casillas_small" id="marca" size="15" maxlength="50" value="<?php echo regresa_copc("maquinaria","Marca","IdMaquinaria",$v["IdMaquinaria"],"r")?>"></td>
     <td colspan="2" align="center" ><input name="modelo" type="text" class="Casillas_small" id="modelo" size="18" maxlength="50" value="<?php echo regresa_copc("maquinaria","Modelo","IdMaquinaria",$v["IdMaquinaria"],"r")?>"></td>
     <td align="center" ><input name="serie" type="text" class="Casillas_small" id="serie" size="18" maxlength="50" value="<?php echo regresa_copc("maquinaria","Serie","IdMaquinaria",$v["IdMaquinaria"],"r")?>"></td>
   </tr>
   <tr class="Concepto" >
     <td align="center" >Marca Motor</td>
     <td colspan="2" align="center" >Modelo Motor</td>
     <td align="center" >Serie Motor</td>
   </tr>
   <tr class="Item1" >
     <td align="center" ><input name="marca_motor" type="text" class="Casillas_small" id="economico2" size="15" maxlength="20" value="<?php echo regresa_copc("maquinaria","Marca_Motor","IdMaquinaria",$v["IdMaquinaria"],"r")?>"></td>
     <td colspan="2" align="center" ><input name="modelo_motor" type="text" class="Casillas_small" id="economico3" size="18" maxlength="20" value="<?php echo regresa_copc("maquinaria","Modelo_Motor","IdMaquinaria",$v["IdMaquinaria"],"r")?>"></td>
     <td align="center" ><input name="serie_motor" type="text" class="Casillas_small" id="economico4" size="18" maxlength="20" value="<?php echo regresa_copc("maquinaria","Serie_Motor","IdMaquinaria",$v["IdMaquinaria"],"r")?>"></td>
   </tr>
   <tr class="Concepto" >
    <td align="center" >Econ&oacute;mico</td>
    <td align="center" >Estado Equipo</td>
    <td align="center">Fecha Llegada</td>
    <td align="center" >Fecha Salida</td>
  </tr>
  
  
  <tr class="Item1">
    <td align="center" >
      <input name="economico" type="text" class="Casillas_small" id="economico" size="10" maxlength="20" value="<?php echo regresa_copc("maquinaria","Economico","IdMaquinaria",$v["IdMaquinaria"],"r")?>" >
    </td>
    <td align="center" ><?php comboSelected("maquinaria_estatus","NombreCorto","IdEstatus",$v["Estatus"])?></td>
    <td align="center" class="Item1"><input name="f_llegada" type="text" class="Casillas_small" id="f_llegada" size="8" maxlength="10" value="<?php echo fecha(regresa_copc("maquinaria","FechaLlegada","IdMaquinaria",$v["IdMaquinaria"],"r"))?>">
    <img src="../../../Imgs/calendarp.gif" width="19" height="21" id="bf_llegada" style="cursor:hand"></td>
    <td align="center" ><input name="f_salida" type="text" class="Casillas_small" id="f_salida" size="8" maxlength="10" value="<?php echo fecha(regresa_copc("maquinaria","FechaSalida","IdMaquinaria",$v["IdMaquinaria"],"r"))?>">
    <img src="../../../Imgs/calendarp.gif" width="19" height="21" id="bf_salida" style="cursor:hand"></td>
  </tr>
  <tr>
     <td colspan="4" align="right"><label>
       <input type="hidden" name="idmaquinaria" id="hiddenField" value="<?php echo $v["IdMaquinaria"] ?>">
       <input name="button" type="submit" class="boton" id="button" value="Registrar">
     </label></td>
  </tr>
</table>
</form>
<table align="center" border="0">
<tr>
<td>
<iframe name="registro" frameborder="0" height="100px" width="600"></iframe>
</td>
</tr>
</table>
</body>
<script type="text/javascript">
			function catcalc(cal) {
		
			}
			Calendar.setup({
				inputField     :    "f_salida",			
				button		   :	"bf_salida",
				ifFormat       :    "%d-%m-%Y",       
				showsTime      :    false,
				timeFormat     :    "24",
				onUpdate       :    catcalc
			});
			
			function catcalc(cal) {
		
			}
			Calendar.setup({
				inputField     :    "f_llegada",			
				button		   :	"bf_llegada",
				ifFormat       :    "%d-%m-%Y",       
				showsTime      :    false,
				timeFormat     :    "24",
				onUpdate       :    catcalc
			});
		</script>
</html>