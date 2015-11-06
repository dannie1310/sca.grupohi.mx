
<?php
	//session_start();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<script src="../../../inc/js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="../../../inc/js/validate.js" type="text/javascript"></script>
<script id="demo" type="text/javascript"> 
$(document).ready(function() {
	// validate signup form on keyup and submit
	var validator = $("#signupform").validate({
		rules: {
			user: "required",
			claveant:"required",
			password: {
				required: true,
				minlength: 5,
			},
			password_confirm: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
		},
		
		messages: {
			user: "Escribe tu nombre de usuario",
			claveant: "Escribe tu contraseña actual",
			password: "Escribe tu nueva contraseña, minimo 5 caracteres",
			
		},
		// the errorPlacement has to take the table layout into account
		errorPlacement: function(error, element) {
			if ( element.is(":radio") )
				error.appendTo( element.parent().next().next() );
			else if ( element.is(":checkbox") )
				error.appendTo ( element.next() );
			else
				error.appendTo( element.parent().next() );
		},
		
		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("checked");
		}
	});
});
</script> 
<style>
.style4 {
	color: #006699;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
</style>
</head>

<body>
<table align="center" width="612" border="0">
      <tr>
        <td class="EncabezadoPagina">
        	<img src="../../../Imgs/16-Editar.gif" width="16" height="16" />&nbsp;SCA.- Cambio de Contraseña 
        </td>
      </tr>
      <tr>
        <td>&nbsp;
        	
        </td>
      </tr>
</table>
<table  border="0" align="center" style="display:none ">
      <tr>
    <?php
        include("../../../inc/php/conexiones/SCA.php");
    ?>
        <td>
        </td>
      </tr>
</table>

<div id="signupbox"> 
      <div id="signupwrap" style="width:500px; position:absolute; left:50%; margin-left:-250px;"> 
      		<form id="signupform" autocomplete="off" method="post" action="2Modifica.php"> 
	  		  <table>
              <tr>
               <td>&nbsp;</td>
              	<td> 
                	<table>
                    	<tr>

                        	<td>&nbsp;
                            
                            </td>
                        </tr>
                     
                      <tr> 
                        <td class="style4"><label id="luser" for="user">Usuario</label></td> 
                      </tr>
                      <tr>
                        <td><input id="user" name="user" type="text" value="" maxlength="100"  class="text"/></td> 
                        <td style="color:#D41F00;"></td> 
                      </tr>
                      <tr>
                      	<td>&nbsp;
                        	
                        </td>
                      </tr>
                      <tr> 
                        <td class="style4"><label id="lclaveant" for="claveant">Contraseña Actual</label></td>

                      </tr>
                      <tr> 
                        <td><input id="claveant" name="claveant" type="password" value=""  class="text" /></td> 
                        <td style="color:#D41F00;"></td> 
                      </tr>
                      <tr>
                      	<td>&nbsp;
                        	
                        </td>
                      </tr> 
                      <tr> 
                        <td class="style4"><label id="lpassword" for="password">Nueva Contraseña</label></td>

                      </tr>
                      <tr> 
                        <td><input id="password" name="password" type="password" value=""  class="text" /></td> 
                        <td style="color:#D41F00;"></td> 
                      </tr>
                      <tr>
                      	<td>&nbsp;
                        	
                        </td>
                      </tr> 
                      <tr> 
                        <td class="style4"><label id="lpassword_confirm" for="password_confirm">Confirma Contraseña</label></td>

                      </tr>
                      <tr> 
                        <td><input id="password_confirm" name="password_confirm" type="password" value="" maxlength="150" class="text" /></td> 
                        <td style="color:#D41F00;"></td> 
                      </tr>
                      <tr>
                      	<td>&nbsp;
                        	
                        </td>
                      </tr>
                      <tr>  
                        <td colspan="2"> 
                        <input id="signupsubmit" name="signup" type="submit" value="Cambiar" class="boton" />
                        <input id="signupsubmit" name="signup" type="reset" value="Borrar" class="boton" />
                        </td> 
                      </tr>

                  </table> 
 				</td>
               
              </tr>
	  		  </table> 
          </form> 
       
</div>
</div>

</body>
</html>