<?php 
function actualizavarios($tabla,$campoid,$id,$campos,$datos)
{
	$ls=SCA::getConexion();
	$cadenacampos="";
	$cadenadatos="";
	$cadenaconsulta="";
	for($i=0;$i<count($campos);$i++)
	{
		if($i<(count($campos)-1))
			{
				$cadenacampos=$cadenacampos.$campos[$i].",";
				$cadenadatos=$cadenadatos."'".$datos[$i]."'".",";
				$cadenaconsulta=$cadenaconsulta.$campos[$i]."="."'".$datos[$i]."', ";
			}
		else
			{
				$cadenacampos=$cadenacampos.$campos[$i];
				$cadenadatos=$cadenadatos."'".$datos[$i]."'";
				$cadenaconsulta=$cadenaconsulta.$campos[$i]."="."'".$datos[$i]."' ";
			}
	
	}
	$update="update ".$tabla." set ".$cadenaconsulta." where ".$campoid."=".$id."; ";
	//echo '$update:'.$update.'<br>';
	$ls->consultar($update);
	//$ls->cerrar();
}

function actualiza($tabla,$campoid,$id,$campo,$dato)
{
	$ls=SCA::getConexion();
	
	$uptade="update ".$tabla." (".$campo.") values (".$dato.") where ".$campoid."=".$id."; ";
	echo $update.'<br>';
	//$ls->cerrar();
}
function regresah($campo,$i,$r)
{ //echo $campo.$i;
	$valor=$_REQUEST[$campo.$i];
	if($r=="r")
	return $valor;
	else if($r=="e")
	{
	echo $valor;
	?>
<input type="hidden" name="<?php echo $campo.$i; ?>" value="<?php echo $valor ?>" id="hiddenField" />
<?php
}
else 
if($r=="sh")
{
?>
<input type="hidden" name="<?php echo $campo.$i; ?>" value="<?php echo $valor ?>" id="hiddenField" />
<?php
}
}
function regresav($tabla,$campo,$id,$valorid)
	{
		$ls=SCA::getConexion();
		$sql="select ".$campo." from ".$tabla." where ".$id."=".$valorid.";";
		//echo $sql;
		$ri=$ls->consultar($sql);
		$vi=mysql_fetch_array($ri);
		$e=$ls->affected();

		if($e>0)
		{
			return $vi[$campo];
		}
		else
			return "- - -";

		//$ls->cerrar();
	}
function comboSelectedN($tabla,$campo,$id,$parametro,$n)
	{

?>

	 <select name="<?php echo $tabla.$n; ?>">
	 
 <?PHP
	  $ls=SCA::getConexion();
	  $sql="select * from $tabla order by $campo asc";
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
function title($tipo)
		{
			if($tipo==0)
				echo "Completos";
			else
			if($tipo==10)
				echo "Sin Origen";
			else
			if($tipo==20)
				echo "Manuales";
		}
?>

