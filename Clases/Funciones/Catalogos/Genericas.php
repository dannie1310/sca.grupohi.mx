<?php
function comboConsecutivo($tabla,$campo,$id,$no,$idelemento,$tipo)
	{
 $ls=SCA::getConexion();
			  $sql="select * from $tabla where Estatus=1 order by ".$campo." asc";
			  //echo $sql;
?>

	 	<select id="<?php echo $idelemento; ?>" name="<?php echo $tabla.$no; ?>">
		 <option value="A99">- SELECCIONE -</option>
			  <?PHP
			 
			  $result=$ls->consultar($sql);
			  $ls->cerrar();
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
			   <option <?php if($tipo==$row[$id]) echo "selected"; ?>  value="<?php echo $row[$id]; ?>"><?php echo $row[$campo]; ?></option>
			   <?php
			   }
			   ?>
		  </select>

	<?php


}



	function fecha($cambio){ //echo $cambio;
		$partes=explode("-", $cambio);
		$dia=$partes[2];
		$mes=$partes[1];
		$a�o=$partes[0];
		$Fecha=$dia."-".$mes."-".$a�o;
		return ($Fecha);
	}


	function fechasql($cambio){ //echo $cambio;
		$partes=explode("-", $cambio);
		$dia=$partes[0];
		$mes=$partes[1];
		$a�o=$partes[2];
		$Fechasql=$a�o."-".$mes."-".$dia;
		return ($Fechasql);
	}


	function regresa($tabla,$campo,$id,$valorid){
		$ls=SCA::getConexion();
		$sql="select ".$campo." from ".$tabla." where ".$id."=".$valorid.";";
		//echo $sql;
		$ri=$ls->consultar($sql);
		$vi=mysql_fetch_array($ri);
		$e=$ls->affected();

		if($e>0)
		{
			echo $vi[$campo];
		}
		else
			echo "- - -";

		//$ls->cerrar();
	}
	function regresa_copc($tabla,$campo,$id,$valorid,$r)
	{
		$ls=SCA::getConexion();
		$sql="select ".$campo." from ".$tabla." where ".$id."=".$valorid.";";
		//echo $sql;
		$ri=$ls->consultar($sql);
		$vi=mysql_fetch_array($ri);
		$e=$ls->affected();
		if($r=="e")
		{
			if($e>0)
			{
				echo $vi[$campo];
			}
			else
				echo "- - -";
		}
		else
		if($r=="r")
		{
			if($e>0)
			{
				return $vi[$campo];
			}
			else
				return "- - -";
		}

		//$ls->cerrar();
	}


	function regresaf($tabla,$campo,$id,$valorid)
	{
		$ls=SCA::getConexion();
		$sql="select $campo from $tabla where $id=$valorid ";
		$ri=$ls->consultar($sql);
		$vi=mysql_fetch_array($ri);
		$e=$ls->affected();

		if($e>0)
		{
			echo fecha($vi[$campo]);
		}
		else
			echo "- - -";

		//$ls->cerrar();
	}


	function comboSelected($tabla,$campo,$id,$parametro)
	{
		$ls=SCA::getConexion();
	  $sql="select * from $tabla order by $campo asc";
?>

	 <select name="<?php echo $tabla; ?>">
	 <option value="A99">- SELECCIONE -</option>
 <?PHP
	  
	  // echo $sql;
	  $result=$ls->consultar($sql);
	  //$ls->cerrar();

	  while($row=mysql_fetch_array($result))
	  {
?>
	   	<option <?php if($parametro==$row[$id]) echo "selected"; ?>  value="<?php echo $row[$id]; ?>"><?php echo $row[$campo]; ?></option>
<?php
	   }
?>
	  </select>

<?php

}

	function combo($tabla,$campo,$id)
	{

?>

	 	<select name="<?php echo $tabla; ?>">
		 <option value="A99">- SELECCIONE -</option>
			  <?PHP
			  $ls=SCA::getConexion();
			  $sql="select * from $tabla where Estatus=1 order by $campo asc";
			 // echo $sql;
			  $result=$ls->consultar($sql);
			  //$ls->cerrar();
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
			   <option <?php if($tipo==$row[$id]) echo "selected"; ?>  value="<?php echo $row[$id]; ?>"><?php echo $row[$campo]; ?></option>
			   <?php
			   }
			   ?>
		  </select>

	<?php


}

function combo_cargador_padre($tabla,$campo,$id,$consec,$nohijos)
	{

?>

	 	<select name="<?php echo $tabla.$consec; ?>" id="<?php echo $tabla."_".$consec; ?>"  onchange="selecciona_cargador(this.value,this.id,'<?php echo $nohijos ?>')">
		 <option value="A99">- SELECCIONE -</option>
			  <?PHP
			  $ls=SCA::getConexion();
			  $sql="select * from $tabla where Estatus=1 order by $campo asc";
			 // echo $sql;
			  $result=$ls->consultar($sql);
			  //$ls->cerrar();
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
			   <option <?php if($tipo==$row[$id]) echo "selected"; ?>  value="<?php echo $row[$id]; ?>"><?php echo $row[$campo]; ?></option>
			   <?php
			   }
			   ?>
		  </select>

	<?php


}

function combo_cargador_hijo($tabla,$campo,$id,$consec_padre,$consec)
	{

?>

	 	<select name="<?php echo $tabla.$consec; ?>" id="<?php echo $tabla."_".$consec_padre."_".$consec; ?>" >
		 <option value="A99">- SELECCIONE -</option>
			  <?PHP
			  $ls=SCA::getConexion();
			  $sql="select * from $tabla where Estatus=1 order by $campo asc";
			 // echo $sql;
			  $result=$ls->consultar($sql);
			  //$ls->cerrar();
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
			   <option <?php if($tipo==$row[$id]) echo "selected"; ?>  value="<?php echo $row[$id]; ?>"><?php echo $row[$campo]; ?></option>
			   <?php
			   }
			   ?>
		  </select>

	<?php


}


function comboBoton($tabla,$campo,$id)
{

	?>


	 <select name="<?php echo $tabla; ?>">
			  <option value="A99">- SELECCIONE -</option>
			  <?PHP
			  $ls=SCA::getConexion();
			  $sql="select * from $tabla where TipoBoton=2 and Estatus=1 order by $campo asc";
			 // echo $sql;
			  $result=$ls->consultar($sql);
			  //$ls->cerrar();
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
			   <option <?php if($tipo==$row[$id]) echo "selected"; ?>  value="<?php echo $row[$id]; ?>"><?php echo $row[$campo]; ?></option>
			   <?php
			   }
			   ?>
		  </select>

	<?php


}


 ?>
 <?php
 function comboBotonN($tabla,$campo,$id)
{

	?>


	 <select name="<?php echo $tabla; ?>N" onchange="cambiaNuevo()">
			  <option value="A99">- SELECCIONE -</option>
			  <?PHP
			  $ls=SCA::getConexion();
			  $sql="select * from $tabla where TipoBoton=2 and Estatus=1 order by $campo asc";
			 // echo $sql;
			  $result=$ls->consultar($sql);
			  //$ls->cerrar();
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
			   <option <?php if($tipo==$row[$id]) echo "selected"; ?>  value="<?php echo $row[$id]; ?>"><?php echo $row[$campo]; ?></option>
			   <?php
			   }
			   ?>
		  </select>

	<?php


}



 function comboProyecto($tabla,$campo,$id,$IdProyecto)
{

	?>


	 <select name="<?php echo $tabla; ?>">
			  <option value="A99">- SELECCIONE -</option>
			  <?PHP
			  $ls=SCA::getConexion();
			  $sql="select * from $tabla where Estatus=1 and IdProyecto=$IdProyecto order by $campo asc";
			 // echo $sql;
			  $result=$ls->consultar($sql);
			  //$ls->cerrar();
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
			   <option   value="<?php echo $row[$id]; ?>"><?php echo $row[$campo]; ?></option>
			   <?php
			   }
			   ?>
		  </select>

	<?php


}


function comboSelectedProyecto($tabla,$campo,$id,$parametro,$IdProyecto)
{

	?>


	 <select name="<?php echo $tabla; ?>">
			  <option value="A99">- SELECCIONE -</option>
			  <?PHP
			  $ls=SCA::getConexion();
			  $sql="select * from $tabla where Estatus=1 and IdProyecto=$IdProyecto order by $campo asc";
			 // echo $sql;
			  $result=$ls->consultar($sql);
			  //$ls->cerrar();
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
			   <option <?php if($parametro==$row[$id]) echo "selected"; ?>  value="<?php echo $row[$id]; ?>"><?php echo $row[$campo]; ?></option>
			   <?php
			   }
			   ?>
		  </select>

	<?php


}

function comboBotonMaterialesSelected($tabla,$campo,$id,$IdProyecto,$parametro)
{

	?>
	
	
	 <select name="<?php echo $tabla; ?>">
			  <option value="A99">- SELECCIONE -</option>
			  <?PHP 
			  $ls=SCA::getConexion();
			  $sql="select * from $tabla where TipoBoton=1 and Estatus=1 and IdProyecto=$IdProyecto order by $campo asc";
			 // echo $sql;
			  $result=$ls->consultar($sql);
			  //$ls->cerrar();
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
			   <option  <?php if($parametro==$row[$id]) echo "selected"; ?>  value="<?php echo $row[$id]; ?>"><?php echo $row[$campo]; ?></option>
			   <?php 
			   }
			   ?>
		  </select>
	
	<?php
	

}


 ?>