<?php
function obtennivel($argp)
{
		$link=SCA::getConexion();
		if($argp==0)
		{	
			
			$nivels="select substr(Nivel,1,3) as Nivel from centroscosto where IdProyecto=".$_SESSION[Proyecto]." and length(Nivel)=4 order by Nivel desc limit 1";
			$res=$link->consultar($nivels);
			$n=mysql_fetch_array($res);
			$ultimonivel=$n[Nivel];
			
			
			$nvo=$ultimonivel+1;
			$longitudnvo=strlen($nvo);
			
			$ceros=3-$longitudnvo;
			$ce='';
			
			for($i=1;$i<=$ceros;$i++)
			{
				$ce=$ce.'0';
			
			}
			$nvo=$ce.$nvo.'.';
			
			return $nvo;
		}
		else
		{
		
			
			$nivels="select Nivel as NivelPadre,substr(Nivel,1,3) as NivelHijo from centroscosto where IdProyecto=".$_SESSION[Proyecto]." and IdCentroCosto=".$argp." order by Nivel desc limit 1";
			
			$res=$link->consultar($nivels);
			$n=mysql_fetch_array($res);
			$ultimohijo="select Nivel as NivelPadre,substr(Nivel,1,3) as NivelHijo from centroscosto where Nivel like '".$n[NivelPadre]."___%' and IdProyecto=".$_SESSION[Proyecto]." order by Nivel desc limit 1";
			//echo $ultimohijo;
			$resultimo=$link->consultar($ultimohijo);
			$nu=mysql_fetch_array($resultimo);
			$ultimonivel=$nu[NivelPadre];
			//echo "ultimo $ultimonivel";
			$arrultimonivel=explode('.',$ultimonivel);
			$no=sizeof($arrultimonivel)-2;
			if($no=='-1')
			{
				$no=1;
				$flag=1;
			}
			//echo '<br>$no: '.$no;
			//echo '<br>$ultimonivel: '.$arrultimonivel[$no];
			$nvo=$arrultimonivel[$no]+1;
			
			//echo '$nvo: '.$nvo;
			$longitudnvo=strlen($nvo);
			//echo '<br>lnvo'.$longitudnvo.'<br>';
			$ceros=3-$longitudnvo;
			//echo '<br>ceros'.$ceros.'<br>';
			$ce='';
			
			for($i=1;$i<=$ceros;$i++)
			{
				$ce=$ce.'0';
			
			}
			$nvo=$ce.$nvo;
			$arrultimonivel[$no]=$nvo;
			//echo '<br>$ultimonivel: '.$arrultimonivel[$no];
			$new='';
			for($o=0;$o<=$no;$o++)
			{
				$new=$new.$arrultimonivel[$o].'.';
				//echo '<br>entra $new: '.$new;
			}
			if($flag==1)
			{ //echo "<br> $n[NivelPadre] CON FLAG<BR>";
			$new=$n[NivelPadre].$arrultimonivel[$no].'.';}
			return $new;
		
		}
		$link->cerrar();
}

function ancestros($padre)
{
	$link=SCA::getConexion();
	$sql="select Nivel, length(Nivel) as Longitud from centroscosto where IdCentroCosto=".$padre."";
	$r=$link->consultar($sql);
	
	$v=mysql_fetch_array($r);
	$n=$v[Nivel];
	$l=$v[Longitud];
	$nn=$l/4;#SE MUESTRA EL NÚMERO DE NIVELES QUE TIENE (NUMERO DE ANCESTROS)
	//echo '<BR>NIVELES: '.$n.', NN: '.$nn.', LONGITUD: '.$l;
	$an=4;
	for($i=0;$i<$nn;$i++)
	{
		$ancestro[1][$i]=substr($n,0,$an);
		$sqldescripcion="select Descripcion, IdCentroCosto,concat(repeat('&nbsp;&nbsp;&nbsp;',(length(Nivel)/4)),'=> ',Descripcion)as DescripcionC from centroscosto where Nivel='".$ancestro[1][$i]."' and IdProyecto=".$_SESSION[Proyecto]."";
		$rd=$link->consultar($sqldescripcion);
		$vd=mysql_fetch_array($rd);
		$ancestro[2][$i]=$vd[Descripcion];
		$ancestro[3][$i]=$vd[DescripcionC];
		$ancestro[4][$i]=$vd[IdCentroCosto];
		//echo '<br>Nivel: '.$ancestro[1][$i].', Descripcion: '.$ancestro[2][$i].', Id: '.$ancestro[4][$i];
		$an=$an+4;
	}
	//$link->cerrar();
	return $ancestro;
}


 ?>

