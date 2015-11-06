<?php
/**
 * Sistema de Control de Acarreos
 *
 * 2015 (c) Grupo Hermes Infraestructura
 */
session_start();
include("../../inc/php/conexiones/SCA.php");
$sca = SCA::getConexion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="../../inc/js/jquery-ui-1.8.16.custom/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
        <link href="../../inc/js/jquery-ui-1.8.16.custom/development-bundle/themes/base/jquery.ui.theme.css" rel="stylesheet" type="text/css" />
        <link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
        <link href="../../css/advertencias.css" rel="stylesheet" type="text/css" />
        <script src="../../inc/js/jquery-1.4.4.js"></script>
        <script src="../../inc/js/jquery-ui-1.8.16.custom/js/jquery-ui-1.8.16.custom.min.js"></script>
        <script>
            var ADV = {
                setAdv: function (data, del) {
                    del_i = 3000;
                    if (del == undefined || del == 0 || del == '') {
                        del = del_i;
                    }
                    $("div#mensajes div#mnsj.np").detach();
                    $("div#mensajes div#mnsj.p").detach();
                    $("#mensajes").append("<div id='mnsj' class='" + data.kind + " np'>" + data.msg + "</div>");
                    $("div#mensajes div#mnsj.np").fadeIn("slow").delay(del).fadeOut("slow");
                    $("div#mensajes div#mnsj.p").fadeIn("slow");
                },
                setAdvBig: function (div, data) {
                    $(div).html("<div id='mnsj_big' class='" + data.kind + " np'>" + data.msg + "</div>");
                }

            };

            $("select#idusuario").live("change", function () {
                valor = $(this).val();
                if (valor === "A99") {
                    $("div#lista_origenes").html("");
                } else {
                    IdUsuario = valor;
                    datos = "IdUsuario=" + IdUsuario;
                    $.post("listaOrigenes.php", datos, function (data) {
                        $("div#lista_origenes").html(data);
                    });
                }
            });
            $("img.cambiar_asignacion").live("click", function () {
                IdUsuario = $(this).attr("IdUsuario");
                IdEstatus = $(this).attr("IdEstatus");
                IdOrigen = $(this).attr("IdOrigen");
                datos = "IdEstatus=" + IdEstatus + "&IdOrigen=" + IdOrigen + "&IdUsuario=" + IdUsuario;
                if (IdEstatus === "1" || IdEstatus === "2") {
                    if (confirm('La asignación del origen cambiará, ¿desea continuar?')) {
                        $.getJSON("jq/cambiar_asignacion.php", datos, function (data) {
                            if (data.kind == "green") {
                                datos = "IdUsuario=" + IdUsuario;
                                $.post("listaOrigenes.php", datos, function (data) {
                                    $("div#lista_origenes").html(data);
                                });
                            }
                        });
                    }
                }
            });


            $(function () {
                $("#dialog:ui-dialog").dialog("destroy");

                $('#dialog').dialog({
                    modal: true,
                    autoOpen: false,
                    width: 500,
                    buttons:
                            {
                                "Cerrar": function () {
                                    $(this).dialog("close");
                                }
                            }
                });

            });
        </script>
        <style>
            .reporte{border:#ccc solid 1px; color:#333;}
            table.reporte thead th, table.reporte tfoot td{ background-image:url(../../Imgs/bg_black.png); background-color:#CCC; color:#FFF; font-weight:bold;}
            table.reporte.cuenta_bancaria thead th, table.reporte.cuenta_bancaria tfoot td{ background-image:url(../../Imgs/bg_gris.png); background-color:#CCC; color:#000; font-weight:bold;}
            table.reporte caption{ text-align:left; font-size:14px; color:#333; font-weight:bold; cursor:pointer; }
            div.contenedor_reportes table.reporte caption{ display:none};
            table.reporte td, table.reporte th{ padding:2px; color:#333;}
            table.reporte td{ border-bottom:1px #CCC dotted;}
            table.reporte td.concepto, table.reporte th.concepto{ }
            table.reporte td.importe,table.reporte th.importe{ width:70px;}
            table.reporte th.fecha,table.reporte td.fecha{ width:60px; text-align:center;}
            table.reporte tr.agrupador:hover{ background-color:#CCC}
            table.reporte td.monetario{ text-align:right;}
            table.reporte td.contenedora{ padding:0px;}
            table.reporte td.contenedora table.reporte { border:none}
            table.reporte tr:hover,table.cuenta_bancaria tr:hover, tr.ingresos:hover, tr.egresos:hover{ background: url(../../Imgs/bg_5.png);}
            tr.ingresos:hover, tr.egresos:hover{ cursor:pointer;}
        </style>
        <title>Origenes</title>
    </head>
    <body>
        <table align="center" width="800" border="0">
            <tr>
                <td class="EncabezadoPagina"><img src="../../Imgs/16-CentrosCosto.gif" width="16" height="16" />&nbsp;SCA.- Origenes por Usuario</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
        <br />
        <div id="tabla">
            <div style="margin:0 0 20px 20px">
                <span style="margin:5px; font-size: 14px; font-weight: bold; color:#333">Usuario:</span>
                <select name="idusuario" id="idusuario" style="font-size:12px; color:#333"> 
                    <option value="A99">-SELECCIONE-</option>
                    <?php
                    $SQLus = "Select * from vw_usuarios_por_proyecto where id_proyecto = " . $_SESSION["ProyectoGlobal"] . " order by nombre, apaterno, amaterno ";
                    $RSQLus = $sca->consultar($SQLus);
                    while ($VSQLus = $sca->fetch($RSQLus)) {
                        ?>
                        <option value="<?PHP echo $VSQLus["id_usuario_intranet"]; ?>"><?PHP echo $VSQLus["nombre"] . " " . $VSQLus["apaterno"] . " " . $VSQLus["amaterno"]; ?></option>
                    <?php }
                    ?>
                </select>
            </div>
            <div id="lista_origenes">

            </div>
        </div>
        <div id="dialog"></div>
        <div id="mensajes"></div>
    </body>
</html>