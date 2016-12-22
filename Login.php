<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Control de Acarreos.- GHI</title>
<link href="Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="Clases/Js/msn.js"></script>	
<!-- <script type="text/javascript" src="Clases/Js/NoClick.js"></script> -->
<style type="text/css">
    .style1 {	font-size: 36px;
            font-weight: bold;
            color: #FFFFFF;
            font-style: italic;/*cambio pedro*/
    }
    #apDiv1 {
            position:absolute;
            left:582px;
            top:369px;
            width:206px;
            height:105px;
            z-index:1;
    }
</style>
</head>
<body style="background: url(css/imagenes/backg1000.gif) repeat-y scroll center center #D4D4D4;">
    <div style="background-color:#FFF; width:996px; height:100%; position:absolute; left:50%; margin-left:-498px;">
        <table width="995" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" background="Imagenes/menu/BannerAcarreos.jpg" style="width:1024px; height:60px;">
                    <br /><br />
                </td>
            </tr>
            <tr bgcolor="#000">
                <td width="847" class="Bienvenida"></td>
                <td width="148" class="Bienvenida" align="right"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div align="right" id="version">2016.2.0.1</div>
                </td> 
            </tr>
        </table>
        <br /><br /><br /><br /><br /><br /><br /><br /><br />
        <table width="995" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td width="11">
                    &nbsp;
                </td>
                <td width="120">
                    &nbsp;
                </td>
                <td width="821" colspan="2">
                    <br /><br /><br />
                    <img src="Imagenes/menu/LogoAcarreosPortada.jpg" width="411" height="182"/>
                </td>
            </tr>
        </table>
        <div id="apDiv1" style="position:absolute; margin-top:-100px; margin-left:-25px;">
          <form name="frm" method="post" action="Chk.php">
            <table border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td>
                    <span class="style4">
                        Usuario:
                    </span>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                    <label>
                        <span class="FondoCasillas">
                            <input name="usr" type="text" class="Casillas" id="usr" size="19" />
                        </span>
                    </label>
                </td>
              </tr>
              <tr>
                <td>
                    &nbsp;
                </td>
                <td colspan="2">
                    &nbsp;
                </td>
              </tr>
              <tr>
                <td>
                    <span class="style4">
                        Contrase&ntilde;a:
                    </span>
                </td>
               </tr>
               <tr>
                <td colspan="2">
                    <label>
                        <span class="FondoCasillas">
                            <input name="pwd" type="password" class="Casillas" id="pwd" size="19" />
                        </span>
                    </label>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="2">
                    &nbsp;
                </td>
              </tr>
              <tr>
                <td align="center">
                    <input type="submit" value="Ingresar" />
                </td>	
                <td align="center">
                    <input type="button" value="Borrar" onclick="document.frm.reset()" />
                </td>
              </tr>
            </table>
          </form>
    </div>
</div>
</body>
</html>
