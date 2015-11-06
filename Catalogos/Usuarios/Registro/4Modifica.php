<?php
include("../../../inc/php/conexiones/SCA.php"); 
session_start();
$link=SCA::getConexion();
$e = $_POST['e'];
$id = $_POST['id'] ;
if($id==0){
	echo 'Seleccione un usuario';
	}else{
/*echo $e;
echo $id;*/
$sql = "SELECT * FROM niveles_usuario WHERE IdUsuario = $id AND Id_NivelMenu = $e ";
$con=$link->consultar($sql);
$cuenta = mysql_num_rows($con);
//echo $cuenta;
if($cuenta == 0){
	//echo 'No esta asignado el permiso';
	
	
	$insert = "INSERT INTO niveles_usuario (Id_NivelMenu,IdUsuario) VALUES ($e,$id)";
	$rinsert=$link->consultar($insert);
	}else{
		//echo 'Si esta asignado el permiso';
		$delete = "DELETE FROM niveles_usuario WHERE Id_NivelMenu = $e AND IdUsuario = $id";
		$rdelete=$link->consultar($delete);
		}
		
		
$sql = "SELECT concat(repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',length(nivel_largo)/4),nm.Title) as Concepto,nm.Id_NivelMenu AS NivelMenu,nm.Nivel AS Nivel,nm.Title,nm.nivel_largo AS nivel_largo,nu.Id_NivelMenu,nu.IdUsuario,nu.Id_NivelUsuario FROM niveles_menu AS nm LEFT JOIN niveles_usuario AS nu ON IdUsuario = $id AND nm.Id_NivelMenu = nu.Id_NivelMenu WHERE nm.Estatus = 1 ORDER BY nm.nivel_largo";
$con=$link->consultar($sql);
?>
<table>
<?php
while ($r = mysql_fetch_assoc($con)){
	$Id_NivelMenu = $r['NivelMenu'];
	$Title = $r['Title'];
	$IdUsuario = $r['IdUsuario'];
	$Nivel = $r['Nivel'];
	$nivel_largo = $r['nivel_largo'];
	$Concepto = $r['Concepto'];	
?>

    	<tr>
        	
            	<?php  if($IdUsuario == $id){
					?>
                    <tr bgcolor="#F4F4F4">
                    <td>
                    	<img src="../../../Imagenes/online16.png"/>
                    </td>
                   <td>
                    <span  class="permisos" onclick="elemento(<?php echo $Id_NivelMenu; ?>,<?php echo $id ?>)"><?php echo utf8_encode ($Concepto); ?></span>
                    </td>
                    </tr>
                    <?php
					}else{
					?>
                    <tr bgcolor="#F4F4F4">
                    <td>
                    	<img src="../../../Imagenes/busy16.png"/>
                    </td>
                   	<td>
                    <span class="permisos" onclick="elemento(<?php echo $Id_NivelMenu; ?>,<?php echo $id ?>)"><?php echo utf8_encode ($Concepto); ?></span>
                    </td>
                    </tr>
                    <?php 
					}
					?>
                 
                    
                    
           
        </tr>
    
	<?php
	
	}
	}
?></table>
<style>
.permisos{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	color:#333;
	padding:0px;
	}
</style>