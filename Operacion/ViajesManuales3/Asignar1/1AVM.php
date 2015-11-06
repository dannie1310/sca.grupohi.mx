<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>. . : : GLN.- Sistema de Control de Acarreos : : . .</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="840" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-tool-a.gif" width="16" height="16" /> SCA.- Registro Manual de Viajes</td>
  </tr>
</table>
<form name="frm" method="post" action="2AVM.php">
<table width="800" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td class="Concepto">Seleccione el N&uacute;mero de Camiones a los que se les Cargar&aacute;n Viajes Manuales</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="bottom" class="FondoCasillas">
   	  <span id="spryselect1">
   	  <select name="NumVM" class="Casillas" id="NumVM" style="cursor:hand">
       	  <option>- N&uacute;mero de Camiones -</option>
			<?php
                for($a=1;$a<16;$a++)
                {
                    if($a==1)
						echo'<option value="'.$a.'">'.$a.' Cami&oacute;n</option>';	
					else
						echo'<option value="'.$a.'">'.$a.' Camiones</option>';
						
					
                }
            ?>
      </select>
   	  <span class="selectRequiredMsg" ><br /><br />&nbsp;Falta Seleccionar el N&uacute;mero de Viajes&nbsp;</span><br />
      </span>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
      <input name="button" type="submit" class="boton" id="button" value="Siguiente" />
    </td>
  </tr>
</table>
</form>
<script type="text/javascript">
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
//-->
</script>
</body>

</html>
