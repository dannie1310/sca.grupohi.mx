<?php 
include("../../../inc/php/conexiones/SCA.php");
echo  $_REQUEST["counter"];
$i = $_REQUEST["counter"];
$var_origen=$_REQUEST["origen".$i];$var_tiro=$_REQUEST["tiro".$i];$var_tipo_ruta=$_REQUEST["tipo_ruta".$i];$var_pk=$_REQUEST["pk".$i];$var_ks=$_REQUEST["ks".$i];$var_ka=$_REQUEST["ka".$i];
$var_tk=$_REQUEST["tk".$i];
$l = SCA::getConexion();
	$l->consultar("start transaction");
	$SQLs = "call sca_sp_registra_ruta($var_origen,$var_tiro,$var_tipo_ruta,$var_pk,$var_ks,$var_ka,".$var_tk.",".$_SESSION["Proyecto"].",".$_SESSION["IdUsuarioAc"].",@respuesta)";
	//$respuesta->alert($SQLs);
	$r=$l->consultar($SQLs);
		$v=$l->fetch($r);
		
		$r2=$l->consultar("select @respuesta");
		$v2=$l->fetch($r2);
		
		if($v2["@respuesta"]!='')
		{
			$mensaje=$v2["@respuesta"];
			$mensaje=explode("-",$mensaje);
			$estado='<img src="../../../Imagenes/'.$mensaje[0].'.gif" width="16" height="16" />'.($mensaje[1]);
			
			if($mensaje[0]=='ok')
			{
				if(($tiempo!=0&&$tiempo!='')&&($tolerancia!=0&&$tolerancia!=''))
				{
				
					$SQLs = "call sca_sp_registra_cronometria(".$mensaje[2].",$tiempo,$tolerancia,".$_SESSION["IdUsuarioAc"].",@respuesta2)";
					//$respuesta->alert($SQLs);
					$r2=$l->consultar($SQLs);
					
					$r3=$l->consultar("select @respuesta2");
					$v3=$l->fetch($r3);
					$mensaje2=$v3["@respuesta2"];
					$mensaje2=explode("-",$mensaje2);
					if($mensaje2[0]=='ok')
					{
						//$respuesta->alert(utf8_decode($mensaje[1]));
						$l->consultar("commit");
					}
					else
					{
						//$respuesta->alert("Hubo un error durante el registro, intentelo nuevamente1");	
						$l->consultar("rollback");
					}
				}
				else
				{
					//$respuesta->alert(utf8_decode($mensaje[1]));
					$l->consultar("commit");
				}
				//$respuesta->alert($mensaje[2]);
				
			}
			else
			{
				//$respuesta->alert($mensaje[1]);
				$l->consultar("rollback");
			}
		}
		else
		{
			$estado='<img src="../../../Imagenes/ko.gif" width="16" height="16" />Hubo un error durante el registro, intentelo nuevamente';
			//$respuesta->alert("Hubo un error durante el registro, intentelo nuevamente2");
			$l->consultar("rollback");
			//$respuesta->assign("div_estado","innerHTML",$estado);
		}


?>