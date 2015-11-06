<?php 
function formulario_manual()
{
	$respuesta=new xajaxResponse();
	$l = $GLOBALS["l"];
	$frm_contenido='<form name="frm_boton_manual" id="frm_boton_manual">
<table width="508" border="1" style="width:auto">
  <tr>
    <td class="detalle"><div id="div_estado"><img src="../../../Imagenes/alert-16.gif" width="16" height="16" />Ingrese los datos que se solicitan a continuaci&oacute;n</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr class="Item1">
        <td width="199" align="center"><strong>Identificador</strong></td>
        <td width="361" align="center"><strong>Tipo de Bot&oacute;n</strong></td>
      </tr>
      
      <tr class="Item">
        <td align="center"><label>
          <input name="identificador" type="text" class="texto" id="identificador" />
          </label></td>
        <td align="center">'.$l->regresaSelectBasicoRet("tiposbotones","IdTipoBoton","Descripcion","Estatus=1","desc",true).'</td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right"><input type="button" class="boton" value="Registrar" onclick="if(valida(this.form.id,\'&iquest; Est&aacute; seguro de Registrar el Bot&oacute;n ?\')){xajax_registra_boton(xajax.getFormValues(\'frm_boton_manual\'))}"/></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>';
	//$frm_contenido=file_get_contents("Formularios/manual.php");
	$respuesta->assign("div_contenido","innerHTML",utf8_encode($frm_contenido));
	//$respuesta->assign("div_contenido","innerHTML","ss");
	return $respuesta;
}
function formulario_archivo()
{
	$respuesta=new xajaxResponse();
	$frm_contenido = '
	<form name="frm_boton_archivo" id="frm_boton_archivo"  method="post" enctype="multipart/form-data" action="Formularios/procesa_archivo.php" >
<table width="508" border="1" style="width:auto" class="formulario">
  <tr>
    <td class="detalle"><div id="div_estado"><img src="../../../Imagenes/alert-16.gif" width="16" height="16" />Indique la ruta del archivo del cual se tomar&aacute;n los datos de los botones</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table style="width:100%" border="0" align="center" cellpadding="0" cellspacing="0">
      
      <tr>
        <td colspan="2" align="center"><input name="archivo_botones" type="file" class="texto" id="archivo_botones" /></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td width="199" align="center">&nbsp;</td>
        <td width="361" align="right"><button class="boton" onclick="this.form.submit()"><img src="../../../Imagenes/upload.gif" width="16" height="16" />Registrar</button></td>
      </tr>
    </table></td>
  </tr>
</table>
<iframe frameborder="none" id="frame" name ="frame" height="1px" width="1px"></iframe>
</form>
	';
	$respuesta->assign("div_contenido","innerHTML",$frm_contenido);
	//$respuesta->assign("div_contenido","innerHTML","ss");
	return $respuesta;
}
function registra_boton($frm)
{
	$respuesta=new xajaxResponse();
	$sql="call sca_registra_boton(".$_SESSION["Proyecto"].",'".$frm["identificador"]."',".$frm["tiposbotones"].",@Respuesta)";
	$l = $GLOBALS["l"];
	$r=$l->consultar($sql);
	//$v=$l->fetch($r);
	
	$r2=$l->consultar("select @Respuesta");
	$v2=$l->fetch($r2);
	
	if($v2["@Respuesta"]!='')
	{
		$mensaje=$v2["@Respuesta"];
		$mensaje=explode("-",$mensaje);
		$estado='<img src="../../../Imagenes/'.$mensaje[0].'.gif" width="16" height="16" />'.($mensaje[1]);
		
			$respuesta->assign("div_estado","innerHTML",utf8_decode($estado));
		
		
	}
	else
	{
		
		$estado='<img src="../../../Imagenes/ko.gif" width="16" height="16" />Hubo un error durante el registro, intentelo nuevamente';
		
			$respuesta->assign("div_estado","innerHTML",utf8_decode($estado));
	}
	return $respuesta;
}
?>