<?php 
function regresaFecha($cambio,$select)
{
	//echo 'cambio: '.$cambio.'<br>';
	$partes=explode("-", $cambio); 
	$dia=$partes[0];
	$mes=$partes[1];
	$a�o=$partes[2];
	if ($select==1)
	return ($dia);
	else
	if($select==2)
	return ($mes);
	else
	if($select==3)
	return ($a�o);
}
function regresa($cambio,$select)
{
	$partes=explode("-", $cambio); 
	$dia=$partes[0];
	$mes=$partes[1];
	$a�o=$partes[2];
	if ($select==1)
	return ($dia);
	else
	if($select==2)
	return ($mes);
	else
	if($select==3)
	return ($a�o);
	
}
	function fechasql($cambio)
	{ //echo $cambio;
		$partes=explode("-", $cambio);
		$dia=$partes[0];
		$mes=$partes[1];
		$a�o=$partes[2];
		$Fechasql=$a�o."-".$mes."-".$dia;
		return ($Fechasql);
	}

function rango($f1,$f2,$tipo)
{
$a�o1=regresa($f1,3);
$a�o2=regresa($f2,3);

$mes1=regresa($f1,2);
$mes2=regresa($f2,2);

$dia1=regresa($f1,1);
$dia2=regresa($f2,1);


$ii=0;
if($a�o1<$a�o2)
{
	$numeroa�os=$a�o2-$a�o1;
	for($p=0;$p<=$numeroa�os;$p++)
		{
			$a�o[$p]=$a�o1+$p;
			//echo $a�o[$p].'<br>';
			if($p==0)
			{
				$numeromeses[$p]=12-$mes1;
			//	echo $numeromeses[$p].'<br>';
				
				######
				
				for($q=0;$q<=$numeromeses[$p];$q++)
					{
						$mes[$q]=$mes1+$q;
						$diasmes[$q]=date("t",mktime(0,0,0,$mes[$q],1,$a�o[$p]));
						if($q==0)
						{
							$numerodias[$q]=$diasmes[$q]-$dia1;
							
							for($i=0;$i<=$numerodias[$q];$i++)
							{	
								
										$diasarr[$i]=$dia1+$i;
										if($diasarr[$i]<10)
										$c=0;
										else
										$c='';
										$completa[$ii]="$a�o1-$mes1-$c$diasarr[$i]";
										$completas[$ii]="$c$diasarr[$i]-$mes1-$a�o1";
										$ii++;
								
								//echo 'completa1 '.$completa[$i].'<br>';
							
							}
						}
						else
						if($q!=0&&$q!=$numeromeses[$p])
						{
							$numerodias[$q]=$diasmes[$q];
							for($i=0;$i<$numerodias[$q];$i++)
							{	
			
										$j=$numerodias[$q-1];
										$diasarr[$j]=1+$i;
										if($diasarr[$j]<10)
										{$c=0;}
										else
										$c='';
										if($mes[$q]<10)
										{$cm=0;}
										else
										$cm='';
										$completa[$ii]="$a�o1-$cm$mes[$q]-$c$diasarr[$j]";
										$completas[$ii]="-$c$diasarr[$j]-$cm$mes[$q]-$a�o1";
										$j++;
										$ii++;
								//echo 'completa2 '.$completa[$i].'<br>';
							
							}
						}
						else
						if($q==$numeromeses[$p])
						{
							$numerodias[$q]=$diasmes[$q];
							for($i=0;$i<$numerodias[$q];$i++)
							{	
								
								
										$j=$numerodias[$q-1];
										$diasarr[$j]=1+$i;
										if($diasarr[$j]<10)
										{$c=0;}
										else
										$c='';
										if($mes[$q]<10)
										{$cm=0;}
										else
										$cm='';
										$completa[$ii]="$a�o1-$cm$mes[$q]-$c$diasarr[$j]";
										$completas[$ii]="$c$diasarr[$j]-$cm$mes[$q]-$a�o1";
										$ii++;
										$j++;
									
									
								
								
								//echo 'completa3 '.$completa[$i].'<br>';
							
							}
						}
						
						
					}
		

	
				
				###### ya jala
				
				
			}
			else
			if($p!=0&&$p!=$numeroa�os)
			{
				$numeromeses[$p]=12;
				//echo $numeromeses[$p].'<br>';
				
								######
				
				for($q=0;$q<$numeromeses[$p];$q++)
					{
						$mes[$q]=1+$q;
						$diasmes[$q]=date("t",mktime(0,0,0,$mes[$q],1,$a�o[$p]));
						
							$numerodias[$q]=$diasmes[$q];
							
							for($i=0;$i<$numerodias[$q];$i++)
							{	
								
										$diasarr[$i]=1+$i;
										if($diasarr[$i]<10)
										$c=0;
										else
										$c='';
										if($mes[$q]<10)
										$cm=0;
										else
										$cm='';
										$completa[$ii]="$a�o[$p]-$cm$mes[$q]-$c$diasarr[$i]";
										$completas[$ii]="$c$diasarr[$i]-$cm$mes[$q]-$a�o[$p]";
										$ii++;
								
								//echo 'completa4s '.$completa[$i].'<br>';
							
							}
						
						
						
						
					}
		

	
				
				###### ya jala
			}
			else
			if($p==$numeroa�os)
			{
				$numeromeses[$p]=$mes2;
				//echo $numeromeses[$p].'<br>';
				
				######
				
				for($q=0;$q<$numeromeses[$p];$q++)
					{	
						$mes[$q]=1+$q;
						
						$diasmes[$q]=date("t",mktime(0,0,0,$mes[$q],1,$a�o[$p]));
	
						if($q==0&&($mes[$q]!=$mes2))
						{
							$numerodias[$q]=$diasmes[$q];
							
							for($i=0;$i<$numerodias[$q];$i++)
							{	
								
										$diasarr[$i]=1+$i;
										if($diasarr[$i]<10)
										$c=0;
										else
										$c='';
										if($mes[$q]<10)
										{$cm=0;}
										else
										$cm='';
										$completa[$ii]="$a�o[$p]-$cm$mes[$q]-$c$diasarr[$i]";
										$completas[$ii]="$c$diasarr[$i]-$cm$mes[$q]-$a�o[$p]";
									$ii++;
								
								//echo 'completa5 '.$completa[$i].'<br>';
							
							}
						}
						else
						if($q!=0&&$q!=($numeromeses[$p]-1))
						{
							$numerodias[$q]=$diasmes[$q];
							for($i=0;$i<$numerodias[$q];$i++)
							{	
			
										$j=$numerodias[$q-1];
										$diasarr[$j]=1+$i;
										if($diasarr[$j]<10)
										{$c=0;}
										else
										$c='';
										if($mes[$q]<10)
										{$cm=0;}
										else
										$cm='';
										$completa[$ii]="$a�o[$p]-$cm$mes[$q]-$c$diasarr[$j]";
										$completas[$ii]="$c$diasarr[$j]-$cm$mes[$q]-$a�o[$p]";
										$j++;
										$ii++;
								//echo 'completa6 '.$completa[$i].'<br>';
							
							}
						}
						else
						if(($q==($numeromeses[$p]-1))||($mes[$q]==$mes2))
						{
							$numerodias[$q]=$dia2;
							for($i=0;$i<$numerodias[$q];$i++)
							{	
								
								
										$j=$numerodias[$q-1];
										$diasarr[$j]=1+$i;
										if($diasarr[$j]<10)
										{$c=0;}
										else
										$c='';
										if($mes[$q]<10)
										{$cm=0;}
										else
										$cm='';
										$completa[$ii]="$a�o[$p]-$cm$mes[$q]-$c$diasarr[$j]";
										$completas[$ii]="$c$diasarr[$j]-$cm$mes[$q]-$a�o[$p]";
										$j++;
									$ii++;
									
								
								
								//echo 'completa7 '.$completa[$i].'<br>';
							
							}
						}
						
						
					}
		

	
				
				###### ya jala
			}
		}

}
else
if($a�o1==$a�o2)
{
	if($mes1<$mes2)
	{	
		$numeromeses=$mes2-$mes1;
		for($q=0;$q<=$numeromeses;$q++)
		{
			$mes[$q]=$mes1+$q;
			$diasmes[$q]=date("t",mktime(0,0,0,$mes[$q],1,$a�o1));
			if($q==0)
			{
				$numerodias[$q]=$diasmes[$q]-$dia1;
				
				for($i=0;$i<=$numerodias[$q];$i++)
				{	
					
							$diasarr[$i]=$dia1+$i;
							if($diasarr[$i]<10)
							$c=0;
							else
							$c='';
							$completa[$ii]="$a�o1-$mes1-$c$diasarr[$i]";
							$completas[$ii]="$c$diasarr[$i]-$mes1-$a�o1";
						$ii++;
					
					//echo 'completa4 '.$completa[$i].'<br>';
				
				}
			}
			else
			if($q!=0&&$q!=$numeromeses)
			{
				$numerodias[$q]=$diasmes[$q];
				for($i=0;$i<$numerodias[$q];$i++)
				{	

							$j=$numerodias[$q-1];
							$diasarr[$j]=1+$i;
							if($diasarr[$j]<10)
							{$c=0;}
							else
							$c='';
							if($mes[$q]<10)
							{$cm=0;}
							else
							$cm='';
							$completa[$ii]="$a�o1-$cm$mes[$q]-$c$diasarr[$j]";
							$completas[$ii]="$c$diasarr[$j]-$cm$mes[$q]-$a�o1";
							$j++;
							$ii++;
					//echo 'completa 5'.$completa[$i].'<br>';
				
				}
			}
			else
			if($q==$numeromeses)
			{
				$numerodias[$q]=$dia2;
				for($i=0;$i<$numerodias[$q];$i++)
				{	
					
					
							$j=$numerodias[$q-1];
							$diasarr[$j]=1+$i;
							if($diasarr[$j]<10)
							{$c=0;}
							else
							$c='';
							if($mes[$q]<10)
							{$cm=0;}
							else
							$cm='';
							$completa[$ii]="$a�o1-$cm$mes[$q]-$c$diasarr[$j]";
							$completas[$ii]="$c$diasarr[$j]-$cm$mes[$q]-$a�o1";
							$j++;
						$ii++;
						
					
					
					//echo 'completa6 '.$completa[$i].'<br>';
				
				}
			}
			
			
		}
		

	}
	else
	if($mes1==$mes2)
	{	$numerodias=$dia2-$dia1;
		for($i=0;$i<=$numerodias;$i++)
		{
			
		
			$diasarr[$i]=$dia1+$i;
			if($diasarr[$i]<10)
							{$c='0';}
							else
							$c='';
			$completa[$ii]="$a�o1-$mes1-$c$diasarr[$i]";
			$completas[$ii]="$c$diasarr[$i]-$mes1-$a�o1";
			//echo 'completa7 '.$completa[$i].'<br>';
		$ii++;
		}
	}

}
if($tipo==0)
return $completa;
else
if($tipo==1)
return $completas;
}

?>

 