<?php 
session_start();
include("../../inc/php/conexiones/SCA.php");
include("../../Clases/Funciones/Catalogos/Genericas.php");

$IdProyecto=$_SESSION['Proyecto'];
$fecha=$_REQUEST[fecha];
$tiro=$_REQUEST[tiro];
$tipo=$_REQUEST[tipo];
$importe=$_REQUEST[importe];
$numero=$_REQUEST[numero];
$totalviajes=$_REQUEST[totalviajes];
$suma=$_REQUEST[suma];
$origen=$_REQUEST[origen];
$torigen=$_REQUEST[torigen];
$material=$_REQUEST[material];

//echo 'fdsfs'.$torigen;
//echo "n=$numero, imp=$importe, tiro=$tiro,fecha=$fecha,tipo=$tipo";
$link=SCA::getConexion();
$sql="Select format(sum(ImportePrimerKM),2) as Importe, sum(ImportePrimerKM) as Importesc,  count(IdViaje) as Viajes from viajes where IdMaterial=".$material." and IdTiro=".$tiro." and IdOrigen=".$origen." and FechaLlegada='".$fecha."' AND Estatus in (0,10,20)";
$r=$link->consultar($sql);
$v=mysql_fetch_array($link->consultar($sql));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>..::GLN.-Sistema de Control de Acarreos::..</title>

        <script type="text/javascript" src="../../Clases/Js/NoClick.js"></script>
        <style type="text/css">
            <!--
            .Estilo1 {color: #333;
                      font-size:1px}
            -->
        </style>
    </head>

    <body>

        <table width="500" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
            <tr>
                <td class="EncabezadoPagina"><img src="../../Imgs/16-Signo-Peso.gif" width="16" height="16" /> SCA.- Asignaci&oacute;n de Costos</td>
            </tr>
            <tr>
                <td  /> &nbsp;</td>
            </tr>
        </table>

        <?php if($tipo==1){ 

                    ?>
                    <form action="4Valida.php" method="post" name="frm">
                        <table width="600" border="0" align="center">
                            <input type="hidden" value="<?php echo $totalviajes; ?>" name="totalviajes">
                            <input type="hidden" value="<?php echo $importe; ?>" name="importe">
                            <input type="hidden" value="<?php echo $tiro; ?>" name="tiro">
                            <input type="hidden" value="<?php echo $fecha; ?>" name="fecha">
                            <input type="hidden" value="<?php echo $tipo; ?>" name="tipo">
                            <input type="hidden" value="<?php echo $numero; ?>" name="numero">
                            <tr >
                                <td colspan="3" class="Subtitulo"><img src="../../Imgs/stop.gif" alt="ALTO" width="128" height="128"></td>
                            </tr>
                            <tr >
                                <td colspan="3" class="Subtitulo">&nbsp;</td>
                            </tr>
                            <tr >
                                <td colspan="3" style="color:#333;">¿SON CORRECTOS LOS DATOS DE ASIGNACIÓN DE COSTOS?</td>
                            </tr>
                            <tr >
                                <td colspan="3">&nbsp;</td>
                            </tr>


                            <tr >
                                <td colspan="3">&nbsp;</td>
                            </tr>


                            <?PHP
                            $pr=1;
                            $i=0;
                            while($i<$numero) {?>   
                            <tr>
                                <td width="182" style="background-image:url(../../Imgs/bg_black.png); color:#FFF;">AL CENTRO DE COSTO:</td>
                                <td width="408" colspan="2" style="background-image:url(../../Imgs/bg_black.png); color:#FFF;"><?php echo regresa(centroscosto,Descripcion,IdCentroCosto,$_REQUEST[centroscosto."$i"]); ?></td>
                            </tr>
                            <tr >
                                <td style="background-image:url(../../Imgs/bg_black.png); color:#FFF;">EN LA ETAPA DEL PROYECTO:</td>
                                <td colspan="2" style="background-image:url(../../Imgs/bg_black.png); color:#FFF;"><?php  echo regresa(etapasproyectos,Descripcion,IdEtapaProyecto,$_REQUEST[etapasproyectos."$i"]); ?></td>
                            </tr>
                            <?PHP $i++; $pr++;
                            }?>   
                            <tr style="display:none" >
                                <td colspan="3" align="center" class="textoG"><?php echo $suma; ?></td>
                            </tr>
                            <tr >
                                <td colspan="3" align="center">&nbsp;</td>
                            </tr>   
                        </table>
                    </form>
                    <table width="600" border="0" align="center" class="reporte">
                        <thead>
                            <tr>
                                <th width="71" >FECHA</th>
                                <th width="264">TIRO</th>
                                <th width="82" >NO. VIAJES </th>
                                <th width="65" >IMPORTE</th>
                            </tr>
                        </thead>
                        <tr >
                            <td><?php echo fecha($fecha); ?></td>
                            <td><?php echo regresa(tiros,Descripcion,IdTiro,$tiro); ?></td>
                            <td align="right"><?php echo $v[Viajes]; ?></td>
                            <td align="right">$ <?php echo $v[Importe]; ?></td>
                        </tr>
                        <tr >
                            <td align="right">&nbsp;</td>
                            <td align="right" colspan="2">&nbsp;</td>
                            <td align="right">&nbsp;</td>
                        </tr>
                        <tr >

                            <td align="right">
                        <form name="regresa" action="3SolicitaCentros.php" method="post" id="frm_regresa">
                            <input type="hidden" value="<?php echo $origen; ?>" name="origen" id="hiddenField2">
                            <input type="hidden" value="<?php echo $torigen; ?>" name="torigen" id="hiddenField2">
                            <input type="hidden" value="<?php echo $material; ?>" name="material" id="hiddenField2">
                            <input name="suma" type="hidden" value="<?php echo $suma; ?>">
                            <input name="tiro" type="hidden" value="<?php echo $tiro; ?>">
                            <input name="fecha" type="hidden" value="<?php echo $fecha; ?>">
                            <input name="tipoa" type="hidden" value="<?php echo $tipo; ?>">
                            <input name="numero" type="hidden" value="<?php echo $numero; ?>">
                            <input name="totalviajes" type="hidden" value="<?php echo $totalviajes; ?>">
                            <input name="flag" type="hidden" value="1">
                            <?php 
                            $j=0;
                            while($j<$numero) {?> 
                            <input name="centroscosto<?php echo $j; ?>" type="hidden" value="<?php echo $_REQUEST[centroscosto."$j"]; ?>">
                            <input name="etapasproyectos<?php echo $j; ?>" type="hidden" value="<?php echo $_REQUEST[etapasproyectos."$j"]; ?>">
                            <input name="numero<?php echo $j; ?>" type="hidden" value="<?php echo $_REQUEST[numero."$j"]; ?>">
                            <?php $j++; }?>
                            <input name="Submit" type="button" class="boton2 regresar" value="Regresar">
                            </form>
                            </td>
                            <td align="right" colspan="2">
                                
                            
                        
                        <form name="frm" action="5Registra.php" method="post">
                            <input type="hidden" value="<?php echo $origen; ?>" name="origen" id="hiddenField2">
                            <input type="hidden" value="<?php echo $torigen; ?>" name="torigen" id="hiddenField2">
                            <input type="hidden" value="<?php echo $material; ?>" name="material" id="hiddenField2">
                            <input name="suma" type="hidden" value="<?php echo $suma; ?>">
                            <input name="tiro" type="hidden" value="<?php echo $tiro; ?>">
                            <input name="fecha" type="hidden" value="<?php echo $fecha; ?>">
                            <input name="tipo" type="hidden" value="<?php echo $tipo; ?>">
                            <input name="numero" type="hidden" value="<?php echo $numero; ?>">
                            <input name="importe" type="hidden" value="<?php echo $importe; ?>">
                            <input name="totalviajes" type="hidden" value="<?php echo $totalviajes; ?>">
                            <input name="flag" type="hidden" value="1">
                            <?php 
                            $j=0;
                            while($j<$numero) {?> 
                            <input name="centroscosto<?php echo $j; ?>" type="hidden" value="<?php echo $_REQUEST[centroscosto."$j"]; ?>">
                            <input name="etapasproyectos<?php echo $j; ?>" type="hidden" value="<?php echo $_REQUEST[etapasproyectos."$j"]; ?>">
                            <input name="numero<?php echo $j; ?>" type="hidden" value="<?php echo $_REQUEST[numero."$j"]; ?>">
                            <?php $j++; }?>
                             <input name="Submit" type="submit" class="boton2" value="Registrar" >
                             </form>
                           
                            </td>
                        
                    </tr>
                </table>

                <?php 

} else if($tipo==2){ ?>
    <table width="600" border="0" align="center" class="reporte">
        <form action="4Valida.php" method="post" name="frm">
            <input type="hidden" value="<?php echo $totalviajes; ?>" name="totalviajes">
            <input type="hidden" value="<?php echo $importe; ?>" name="importe">
            <input type="hidden" value="<?php echo $tiro; ?>" name="tiro">
            <input type="hidden" value="<?php echo $fecha; ?>" name="fecha">
            <input type="hidden" value="<?php echo $tipo; ?>" name="tipo">
            <input type="hidden" value="<?php echo $numero; ?>" name="numero">
            <tr >
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr >
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr >
                <td width="273" >CENTRO DE COSTO</td>
                <td width="188" >ETAPA DE PROYECTO</td>
                <td width="125" >IMPORTE</td>
            </tr>

            <?PHP
            $pr=1;
            $i=0;
            while($i<$numero) {?>
            <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
                <td align="center"><?php echo regresa(centroscosto,Descripcion,IdCentroCosto,$_REQUEST[centroscosto."$i"]); ?></td>
                <td align="center"><?php echo regresa(etapasproyectos,Descripcion,IdEtapaProyecto,$_REQUEST[etapasproyectos."$i"]); ?></td>
                <td align="right">$ <?php echo $_REQUEST[numero."$i"]; ?></td>
            </tr>
            <?PHP $i++; $pr++; }?>
            <tr >
                <td align="center" class="textoG">&nbsp;</td>
                <td align="center" class="textoG"></td>
                <td align="right" class="textoG">$ <?php echo $suma; ?></td>
            </tr>
            <tr >
                <td colspan="3" align="center">&nbsp;</td>
            </tr>
        </form>

    </table>
    <table width="500" border="0" align="center" >
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td width="74" class="EncabezadoTabla">FECHA</td>
            <td width="225" class="EncabezadoTabla">TIRO</td>
            <td width="101" class="EncabezadoTabla">NO. VIAJES </td>
            <td width="82" class="EncabezadoTabla">IMPORTE</td>
        </tr>
        <tr class="Item1">
            <td><?php echo fecha($fecha); ?></td>
            <td><?php echo regresa(tiros,Descripcion,IdTiro,$tiro); ?></td>
            <td align="right"><?php echo $v[Viajes]; ?></td>
            <td align="right">$ <?php echo $v[Importe]; ?></td>
        </tr>
        <tr >
            <td align="right">&nbsp;</td>
            <td align="right" colspan="2">&nbsp;</td>
            <td align="right">&nbsp;</td>
        </tr>
        <tr >

            <td align="right">&nbsp;   </td>

        <form name="regresa" action="3SolicitaCentros.php" method="post" id="frm_regresa">
            <input name="origen" type="hidden" value="<?php echo $origen; ?>">
            <input name="suma" type="hidden" value="<?php echo $suma; ?>">
            <input name="tiro" type="hidden" value="<?php echo $tiro; ?>">
            <input name="fecha" type="hidden" value="<?php echo $fecha; ?>">
            <input name="tipoa" type="hidden" value="<?php echo $tipo; ?>">
            <input name="numero" type="hidden" value="<?php echo $numero; ?>">
            <input name="importe" type="hidden" value="<?php echo $importe; ?>">
            <input name="totalviajes" type="hidden" value="<?php echo $totalviajes; ?>">
            <input name="flag" type="hidden" value="1">
            <?php 
            $j=0;
            while($j<$numero) {?> 
            <input name="centroscosto<?php echo $j; ?>" type="hidden" value="<?php echo $_REQUEST[centroscosto."$j"]; ?>">
            <input name="etapasproyectos<?php echo $j; ?>" type="hidden" value="<?php echo $_REQUEST[etapasproyectos."$j"]; ?>">
            <input name="numero<?php echo $j; ?>" type="hidden" value="<?php echo $_REQUEST[numero."$j"]; ?>">
            <?php $j++; }?>

            <td align="right" colspan="2"><input name="Submit" type="button" class="boton2 regresar" value="Regresar"></td>
        </form>
        <form name="frm" action="5Registra.php" method="post">
            <input name="origen" type="hidden" value="<?php echo $origen; ?>">
            <input type="hidden" value="<?php echo $torigen; ?>" name="torigen" id="hiddenField2">
            <input type="hidden" value="<?php echo $material; ?>" name="material" id="hiddenField2">
            <input name="suma" type="hidden" value="<?php echo $suma; ?>">
            <input name="tiro" type="hidden" value="<?php echo $tiro; ?>">
            <input name="fecha" type="hidden" value="<?php echo $fecha; ?>">
            <input name="tipo" type="hidden" value="<?php echo $tipo; ?>">
            <input name="numero" type="hidden" value="<?php echo $numero; ?>">
            <input name="importe" type="hidden" value="<?php echo $importe; ?>">
            <input name="totalviajes" type="hidden" value="<?php echo $totalviajes; ?>">
            <input name="flag" type="hidden" value="1">
            <?php 
            $j=0;
            while($j<$numero) {?> 
            <input name="centroscosto<?php echo $j; ?>" type="hidden" value="<?php echo $_REQUEST[centroscosto."$j"]; ?>">
            <input name="etapasproyectos<?php echo $j; ?>" type="hidden" value="<?php echo $_REQUEST[etapasproyectos."$j"]; ?>">
            <input name="numero<?php echo $j; ?>" type="hidden" value="<?php echo $_REQUEST[numero."$j"]; ?>">
            <?php $j++; }?>
            <td align="right"><input name="Submit" type="submit" class="boton2" value="Registrar" ></td>
        </form>
    </tr>
</table>

<?php }?>


</body>
</html>
