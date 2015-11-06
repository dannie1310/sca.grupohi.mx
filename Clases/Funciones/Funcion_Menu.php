<?php 
function obtiene_Niveles($menuv)
{
	$dn=0;
	$niveles='';
	
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

function obtienehijos($padre,$arregloMenu)
	{
	?>
     <ul  <?php  if($padre==0){?>id="MenuBar1" class="MenuBarVertical" <?php }?>>
			<?php 
                for($x=0;$x<sizeof($arregloMenu["Nivel"]);$x++)
                {
                    if($arregloMenu["IdPadre"][$x]==$padre)
                    {?>
                       <li>
                       			<a <?php if($arregloMenu["Hijos"][$x]==1) { ?>href="#"<?php } else { ?>href="<?php echo $arregloMenu["Ruta"][$x]?>" <?php if($arregloMenu["Campos"][$x]!="CerrarSesion"){ ?> target="Contenido"<?php } }if($arregloMenu["Hijos"][$x]==1) {?>class="MenuBarItemSubmenu"<?php }?>><?php  echo $arregloMenu["Descripcion"][$x]; ?> </a>
                       			<?php  if($arregloMenu["Hijos"][$x]==1){ obtienehijos($arregloMenu["IdNivel"][$x],$arregloMenu); }?>
                       </li>
                    <?php }
                }?> 
		</ul>
		<?php }
?>
