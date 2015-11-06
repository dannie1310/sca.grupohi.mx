<?php 
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<script src="../../../Clases/Js/XHConn.js"></script>
<script type="text/javascript">

 var id_sel="";
  function over(id)
  {
	 // alert(id);
	 if(id!=id_sel)
	 {
	  document.getElementById(id).style.backgroundColor="#CFC";
	 }
	 else
	 {
		 document.getElementById(id).style.backgroundColor="#6f9";
	}
  }
  function out(id)
  {
	 if(id!=id_sel)
	 {
	   document.getElementById(id).style.backgroundColor="#FFF";
	 }
	 else
	 {
		 document.getElementById(id).style.backgroundColor="#FFC";
	 }
  }
  function clic(id)
  {
	  
	  if(id_sel!=id&&id_sel!="")
	  {
		document.getElementById(id_sel).style.backgroundColor="#FFF";
		
	  }
	  id_sel=id;
	   document.getElementById(id).style.backgroundColor="#FFC";
  }
function detalle_equipo(target,IdMaquina) 
{ 
    document.getElementById(target).innerHTML = '<p class="Subtitulo" align="center"><img src="../../../Imgs/loading_big.gif" ></p>'; 
    var myConn = new XHConn(); 
        if (!myConn) alert("XMLHTTP no esta disponible. Inténtalo con un navegador más actual."); 
		//var fnWhenDone = function (obj) { alert(obj.responseText); };
        var peticion = function (oXML) {  document.getElementById(target).innerHTML = oXML.responseText;  
		//detalle_actividades(Id_reporte);
		//detalle_2(Id_reporte);
		}; 
        myConn.connect("2Equipo.php", "POST", "IdMaquina="+IdMaquina, peticion); 
}

</script>
<script>
function valida(f)
{
	form=document.getElementById(f);
	vacios=0;
	completos=0;
	for(m=0;m<form.length-1;m++)
	{
		if(form[m].value==''||form[m].value=='A99')
		{
			
			form[m].style.borderColor="#F00";
			form[m].style.backgroundColor="#FCC";
			vacios++;
		}
		else
		{
			form[m].style.borderColor="#090";
			form[m].style.backgroundColor="#DFFFDF";
		}
		//alert(form[m].value);	
	}
	if(vacios>0)
	{
		return false;
	}
	else
	{
		if (confirm("¿REALMENTE DESEA MODIFICAR LOS DATOS DEL EQUIPO?"))
		{
		return true;
		}
		else
		{
		return false;
		}
	}
}
</script>
<?php 
$link=SCA::getConexion();
$sql="select * from maquinaria";
$r=$link->consultar($sql);?>
</head>

<body>
<table width="600" border="0" align="center" STYLE="overflow:hidden; width:600PX;" >
  <tr class="EncabezadoMenu">
    <td align="center" bgcolor="#E9E9E9" style='width:100px; cursor:e-resize; overflow:hidden'>Econ&oacute;mico</td>
    <td align="center" bgcolor="#E9E9E9">Categor&iacute;a</td>
    <td align="center" bgcolor="#E9E9E9" >Tipo de Equipo</td>
    <td align="center" bgcolor="#E9E9E9">Origen</td>
    <td align="center" bgcolor="#E9E9E9">Estatus</td>
  </tr>

  <?php while($v=mysql_fetch_array($r)){?>
  
  <tr id="<?php echo $v[IdMaquinaria] ?>" class="texto" style="cursor:hand" onMouseOver="over(this.id)" onMouseOut="out(this.id)" onClick="clic(this.id);detalle_equipo('muestra_detalle','<?php echo $v["IdMaquinaria"]  ?>')">
    <td><?php echo $v[Economico] ?>&nbsp;</td>
    <td><?php echo regresa_copc("maquinaria_categorias","Descripcion","IdCategoria",regresa_copc("maquinaria_tipos","IdCategoria","IdTipo",$v["IdTipo"],"r"),"r") ?></td>
    <td><?php echo regresa("maquinaria_tipos","Descripcion","IdTipo",$v["IdTipo"]) ?></td>
    <td><?php  echo regresa("maquinaria_arrendadores","NombreCorto","IdArrendador",$v["IdArrendador"]) ?></td>
    <td align="center"><?php echo regresa_copc("maquinaria_estatus","NombreCorto","IdEstatus",$v["Estatus"],"r") ?></td>
  </tr>
  <?php } ?>
  <tr class="texto" >
    <td colspan="5">&nbsp;</td>
  </tr>
  </table>
  <table width="600" border="0" align="center"  >

  <tr class="texto" >
    <td colspan="5"><div id="muestra_detalle">&nbsp;</div></td>
  </tr>
</table>
<div id="status" style="display:none"></div>
</body>
</html>