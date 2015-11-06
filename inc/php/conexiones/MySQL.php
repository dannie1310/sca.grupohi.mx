<?php 
	class MySQL
	{
		var $enlace;
		var $qryCache=array();
		static $_instance; 

		public function MySQL($srv,$usr,$ctr,$bd)
		{
			try
			{
				$this->enlace=mysql_connect($srv,$usr,$ctr);
				if (!$this->enlace) {
					echo '{"error":"Error al conectarse a la base de datos '.$bd.' "}';
					exit();	
				}			
				if($bd==""){
					echo '{"error":"El nombre de la base de datos es nulll "}';
					exit();
				}
				if($this->setBase($bd)){					
					echo '{"error":"Error al selecionar la base de datos '.$bd.' "}';
					exit();	
				}
			}
			catch(Exception $e)
			{
				echo "Excepción: ".$e->getMessage();
			}
		}
		
		function regresa_Enlace()
		{
			return $this->enlace;	
		}
		function affected()
		{
			return mysql_affected_rows($this->enlace);	
		}
		function setBase($bd)
		{
			try
			{
				mysql_select_db($bd,$this->enlace);
			}
			catch(Exception $e)
			{
				echo "Excepción: ".$e->getMessage();
			}	
		}
		
		function consultar($sql)
		{
			$r=mysql_query($sql,$this->enlace);
			return $r;	
		}
		function fetch($r)
		{
			return mysql_fetch_array($r);
		}
		
		function cacheQuery($sql)
		{
			if( !$result = $this->consultar( $sql ) )
			{
				trigger_error('Error executing and caching query: '.$queryStr.$this->connections[$this->activeConnection]->error, E_USER_ERROR);
				return -1;
			}
			else
			{
				$this->queryCache[] = $result;
				return count($this->queryCache)-1;
			}
		}
		
		function exFnc($sql,$ret)
		{
			$sql="select ".$sql." as ".$ret;
			$r=mysql_query($sql,$this->enlace);
			$v=mysql_fetch_array($r);
			return $v[$ret];	
		}
		function exSP($sql)
		{
			$sql="call ".$sql;
			
			if(!$r=mysql_query($sql,$this->enlace))
			throw new Exception(mysql_error($this->enlace));
			return $r;
		}
		
		function regresaDatos2($tbl,$campo,$campoid, $valorid)
		{
			$sql="select ".$campo." from ".$tbl." where ".$campoid."='".$valorid."'";
			$r=mysql_query($sql,$this->enlace);
			$v=mysql_fetch_array($r);
			return $v[$campo];	
		}
		function regresaDatos($tbl,$campo,$where)
		{
			$sql="select ".$campo." from ".$tbl." ".$where."";
			$r=mysql_query($sql,$this->enlace);
			$v=mysql_fetch_array($r);
			return $v[$campo];	
		}
		
		function regresaSelectBasico($tbl,$campoid,$campo,$condicion,$orden,$sel,$seleccionado=0)
		{
			$sql="select * from ".$tbl." where ".$condicion." order by ".$campo." ".$orden."";
			$r=mysql_query($sql,$this->enlace);
			$select="<select name='".$tbl."' id='".$tbl."'>";
			if($sel){
				$select.="<option value='A99'>- SELECCIONE -</option>";
			}
			while ($v=mysql_fetch_array($r))
			{
				
				$select.="<option value='".$v[$campoid]."'";
				if($seleccionado==$v[$campoid])
				$select.=" selected ";
				$select.=">".$v[$campo]."</option>";
			}
			
			$select.="</select>";
			echo $select;
		
		}
		
		/*function regresaSelectBasicoRet($tbl,$campoid,$campo,$condicion,$orden,$sel,$seleccionado=0,$extra="")
		{
			$sql="select * from ".$tbl." where ".$condicion." order by ".$campo." ".$orden."";
			$r=mysql_query($sql,$this->enlace);
			$select="<select name='".$tbl."' id='".$tbl."' $extra>";
			if($sel){
				$select.="<option value='A99'>- SELECCIONE -</option>";
			}
			while ($v=mysql_fetch_array($r))
			{
				
				$select.="<option value='".$v[$campoid]."'";
				if($seleccionado==$v[$campoid])
				$select.=" selected ";
				$select.=">".$v[$campo]."</option>";
			}
			
			$select.="</select>";
			return $select;
		
		}*/
		
		function regresaSelectBasicoRet($tbl,$campoid,$campo,$condicion,$orden,$sel,$seleccionado=0,$nombre="",$id="",$extras="")
		{
			$nmb=($nombre=="")?$tbl:$nombre;
			$ide=($id=="")?$tbl:$id;
			$sql="select * from ".$tbl." where ".$condicion." order by ".$campo." ".$orden."";
			$r=mysql_query($sql,$this->enlace);
			$select="<select name='".$nmb."' id='".$ide."' ".$extras.">";
			if($sel){
				$select.="<option value='A99'>- SELECCIONE -</option>";
			}
			while ($v=mysql_fetch_array($r))
			{
				
				$select.="<option value='".$v[$campoid]."'";
				if($seleccionado==$v[$campoid])
				$select.=" selected ";
				$select.=">".$v[$campo]."</option>";
			}
			
			$select.="</select>";
			return $select;
		
		}
		
		function regresaSelect($nombre,$cmp,$tbl,$condicion,$campoid,$campo,$orden,$width,$sel,$mul,$size)
		{
			if($mul)
			$mlt="multiple";
			$sql="select ".$cmp." from ".$tbl." where ".$condicion." order by ".$campo." ".$orden."";
			$r=mysql_query($sql,$this->enlace);
			$siz=mysql_affected_rows($this->enlace);
			$id=$nombre;
			if($mul)
			{
				$name=$nombre."[]";
				if($siz>$size)
				$size=$size;
				else
				$size=$siz;
			}
			else
			$name=$nombre;
			$select="<select ".$mlt." size='".$size."' name='".$name."' id='".$id."' style='width:".$width."'>";
			if($sel&&!$mul){
				$select.="<option value='A99'>- SELECCIONE -</option>";
			}
			while ($v=mysql_fetch_array($r))
			{
				
				$select.="<option value='".$v[$campoid]."' title='".$v[$campo]."'>".$v[$campo]."</option>";
			}
			
			$select.="</select>";
			echo $select;
		
		}

		
		function regresaSelect_mult_order($nombre,$cmp,$tbl,$condicion,$campoid,$campo,$orden,$sel,$mul,$size,$evt,$width)
		{
			
			$mlt=0;
			$sql="select ".$cmp." from ".$tbl." where ".$condicion." order by ".$orden."";
			$r=mysql_query($sql,$this->enlace) ;
			$afe=$this->affected();
			if($afe>0)
			{
				$siz=$this->affected();
				$id=$nombre;
				
				if($mul)
				{
					$name=$nombre."[]";
					$mlt="multiple";
					if($siz>$size)
					$size=$size;
					else
					$size=$siz;
				}
				else
				{
					$name=$nombre;
					
					$mlt="";
				}
				$select="<select ".$mlt." size='".$size."' name='".$name."' id='".$id."' ".$evt." style='width:".$width."'>";
				if($sel&&!$mul){
					$select.="<option value='A99'>- SELECCIONE -</option>";
				}
				while ($v=mysql_fetch_array($r))
				{
				
					$select.="<option value='".$v[$campoid]."' title='".utf8_encode($v[$campo])."'>".$v[$campo]."</option>";
				}
			
				$select.="</select>";
				echo $select;
			}
			else
			echo "- - - -";
		
		}

		function regresaSelect_mult_order_ret($nombre,$cmp,$tbl,$condicion,$campoid,$campo,$orden,$sel,$mul,$size,$evt,$width,$selected=0)
		{
			
			$mlt=0;
			$sql="select ".$cmp." from ".$tbl." where ".$condicion." order by ".$orden."";
			$r=mysql_query($sql,$this->enlace);
			$afe=$this->affected();
			if($afe>0)
			{
				$siz=$this->affected();
				$id=$nombre;
				
				if($mul)
				{
					$name=$nombre."[]";
					$mlt="multiple";
					if($siz>$size)
					$size=$size;
					else
					$size=$siz;
				}
				else
				{
					$name=$nombre;
					$mlt="";
				}
				$select="<select ".$mlt." size='".$size."' name='".$name."' id='".$id."' ".$evt." style='width:".$width."'>";
				if($sel&&!$mul){
					$select.="<option value='A99'>- SELECCIONE -</option>";
				}
				while ($v=mysql_fetch_array($r))
				{
				
					$select.="<option value='".$v[$campoid]."' title='".($v[$campo])."'";
					if($selected==$v[$campoid])
					$select.=" selected ";
					$select.=">".($v[$campo])."</option>";
				}
			
				$select.="</select>";
				return $select;
			}
			else
			return "- - - -";
		}


		function returnSelect($cmp,$tbl,$condicion,$campoid,$campo,$orden,$sel,$mul,$size,$evt="")
		{
			if($mul)
			$mlt="multiple";
			$sql="select ".$cmp." from ".$tbl." where ".$condicion." order by ".$campo." ".$orden."";
			$r=mysql_query($sql,$this->enlace);
			$siz=mysql_affected_rows($this->enlace);
			$id=$campo;
			if($mul)
			{
				$name=$campo."[]";
				if($siz>$size)
				$size=$size;
				else
				$size=$siz;
			}
			else{$name=$campo;}
			$select="<select ".$mlt." size='".$size."' name='".$name."' id='".$id."' ".$evt.">";
			if($sel&&!$mul){
				$select.="<option value='A99'>- SELECCIONE -</option>";
			}
			while ($v=mysql_fetch_array($r))
			{
				
				$select.="<option value='".$v[$campoid]."'>".$v[$campo]."</option>";
			}
			$select.="</select>";
			return $select;
		
		}
		function retAfRows($sql)
		{
			$r=mysql_query($sql,$this->enlace);
			$siz=mysql_affected_rows($this->enlace);
			return $siz;
		}
		function retId()
		{
			return mysql_insert_id($this->enlace);	
		}
		
		function cerrar()
		{
			mysql_close($this->enlace);	
		}
		
		function regresaSelect_evt($nombre,$cmp,$tbl,$condicion,$campoid,$campo,$orden,$width,$sel,$mul,$size,$evt,$memo,$salida)
		{
			if($mul)
			$mlt="multiple";
			$sql="select ".$cmp." from ".$tbl." where ".$condicion." order by ".$campo." ".$orden."";
			//echo $sql;
			$r=mysql_query($sql,$this->enlace);
			$siz=mysql_affected_rows($this->enlace);
			$id=$nombre;
			
			if($siz>$size)
				$size=$size;
				else
				$size=$siz;
			
			if($mul)
			{
				$name=$nombre."[]";
				
			}
			else
			$name=$nombre;
			$select="<select ".$mlt." size='".$size."' name='".$name."' id='".$id."' style='width:".$width."' ".$evt.">";
			if($sel&&!$mul){
				$select.="<option value='A99'>- SELECCIONE -</option>";
			}
			$i=0;
			while ($v=mysql_fetch_array($r))
			{
				
				$select.="<option";
				
				if($memo==$v[$campoid]) $select.=" selected ";
				
				
				$select.=" value='".$v[$campoid]."' title='".$v[$campo]."'>".$v[$campo]."</option>";
			$i++;
			}
			
			$select.="</select>";
			if($salida=='e')
			echo $select;
			else
			return $select;
		
		}
		
		function regresaSelect_mult_order_especial($nombre,$id,$cmp,$tbl,$condicion,$campoid,$campo,$orden,$sel,$mul,$size,$evt,$campo_title,$width,$seleccion)
		{
			$mlt=0;
			$sql="select ".$cmp." from ".$tbl." where ".$condicion." order by ".$orden."";
			$r=mysql_query($sql,$this->enlace) ;
			$afe=$this->affected();
			if($afe>0)
			{ 
				$siz=$this->affected();
				if($mul)
				{
					$name=$nombre."[]";
					$mlt="multiple";
					if($siz>$size)
					$size=$size;
					else
					$size=$siz;
				}
				else
				{
					$name=$nombre;
					$mlt="";
				}
				if($width>0)
				$style="style='width:".$width."'";
				$select="<select ".$mlt." size='".$size."' name='".$name."' id='".$id."' ".$evt." ".$style." >";
				if($sel&&!$mul){
					$select.="<option value='A99'>- SELECCIONE -</option>";
				}
				while ($v=mysql_fetch_array($r))
				{
					$select.="<option value='".$v[$campoid]."' title='".utf8_encode($v[$campo_title])."'";
					if($seleccion==$v[$campoid])
					$select.="selected";
					$select.=">".$v[$campo]."</option>";
				}
				$select.="</select>";
				echo $select;
			}
		}
	}
?>