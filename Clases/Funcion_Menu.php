<?php 
function obtiene_Niveles($menuv)
{
	$dn=0;
	$niveles='';
	//echo sizeof($menuv["Nivel"]);
	for($x=0;$x<sizeof($menuv["Nivel"]);$x++)
		{
			$fla=1;
			for($y=0;$y<sizeof($niveles);$y++)
			{
				if($niveles[$y]==$menuv["Nivel"][$x])
				{
				 $fla=0;
				// echo "No Mete";
				}
			}
			
			if($fla==1)
			{
				$niveles[$dn]=$menuv["Nivel"][$x];
				//echo "<br> $dn: ".$niveles[$dn]; 
				$dn++;
			}		
		} 
		return $niveles;
}

function obtienehijos($padre,$arregloMenu,$usr)
	{
	?>
     <ul  <?php  if($padre==0){?> id="SCAMenu" class="MenuBarHorizontal" <?php }?>>
			<?php 
                for($x=0;$x<sizeof($arregloMenu["Nivel"]);$x++)
                {
                    if($arregloMenu["IdPadre"][$x]==$padre)
                    {?>
                       <li>
                       			<a <?php if (($arregloMenu["IdPadre"][$x]==88)&&($arregloMenu["IdNivel"][$x]!=105)){?> target="_blank" <?php }?><?php if($arregloMenu["Hijos"][$x]==1) { ?>href="#"<?php } else { ?>href="<?php echo $arregloMenu["Ruta"][$x].""?>" <?php if($arregloMenu["Campos"][$x]!="D"){ ?> target="content"<?php } }if($arregloMenu["Hijos"][$x]==1) {?>class="MenuBarItemSubmenu"<?php }if($arregloMenu["Title"][$x]!='')echo "title='".$arregloMenu["Title"][$x]."' "; ?>><?php if($arregloMenu["Icono"][$x]!='')echo "<img src='".$arregloMenu["Icono"][$x]."' border='0'>&nbsp;";  echo $arregloMenu["Descripcion"][$x]; ?> </a>
                       			<?php  if($arregloMenu["Hijos"][$x]==1){ obtienehijos($arregloMenu["IdNivel"][$x],$arregloMenu,$usr); }?>
                       </li>
                    <?php }
                }?> 
		</ul>
		<?php }
?>
