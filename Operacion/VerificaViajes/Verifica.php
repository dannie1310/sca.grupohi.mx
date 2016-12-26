<?php 
session_start();
//include("../../inc/php/conexiones/SCA.php");
include("../../Clases/Funciones/Configuracion.php");
include("../../inc/php/conexiones/SCA.php");
require_once("../../Clases/xajax/xajax_core/xajax.inc.php");
require_once("funciones_xjx.php");	
	
function horas($dec) {
		$hours = $dec/60;
		$var = explode(".",$hours);
		$hours = $var[0];
		$mins = (($var[1]*60)/10);
		if(strlen($hours)>1){
			$hours=$hours;
			}else{
				$hours='0'.$hours;
				}
		if(strlen($mins)>1){
			$mins=substr($mins,0,2);
			}else{
				$mins='0'.$mins;
				}
		$hora =  $hours.":".$mins;
		
		return $hora;
		
	}
	
	$l = SCA::getConexion(); 
	$xajax = new xajax(); 	
	//print_r($_SESSION);
	  $SQLs = "SELECT  DATE_FORMAT(viajesnetos.FechaLlegada,'%d-%m-%Y') as Fecha, viajesnetos.FechaLlegada as FechaO, COUNT(viajesnetos.IdViajeNeto) AS Total FROM viajesnetos WHERE (viajesnetos.Estatus = 0 OR viajesnetos.Estatus = 10 OR viajesnetos.Estatus = 20 )AND viajesnetos.IdProyecto = ".$_SESSION['Proyecto']." GROUP BY viajesnetos.FechaLlegada;";
	
	$r=$l->consultar($SQLs);
	$condicion="";	
	
	$xajax->register(XAJAX_FUNCTION,"calculos_x_tipo_tarifa");
	$xajax->register(XAJAX_FUNCTION,"registra_viaje");
	$xajax->processRequest();
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php
            $xajax->printJavascript("../../Clases/xajax/");
        ?>
        <title>Validaci&oacute;n de Viajes</title>
        <link href="../../Estilos/Principal.css" rel="stylesheet" type="text/css" />

        <style type="text/css">
            <!--
            body{
                background-color: #EEE;
            }
            #layout{ 
                margin:0px
            }
            -->
        </style>
        <?php 
            nftcb(substr($_SERVER['PHP_SELF'],1));
        ?>
        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="../../Estilos/js/jquery.bxslider.min.js"></script>
        <link href="../../Estilos/js/jquery.bxslider.css" rel="stylesheet" />
        <script language="javascript" type="text/javascript">



            $(function() {
                $('.tipo_tarifa').on("change",function(){
                    i = $(this).attr("contador");
                    xajax_calculos_x_tipo_tarifa($(this).attr("value"),xajax.$("material"+i).value,i,xajax.$('origen'+i).value,xajax.$('tiro'+i).value,xajax.$('camion'+i).value,xajax.$("idviaje"+i).value,xajax.$("tara"+i).value,xajax.$("bruto"+i).value);
                });

                $('.tipo_tarifa_p').on("keyup",function(){					 	
                    i = $(this).attr("contador");

                    if(xajax.$("tarifa"+i).value=="p")
                        xajax_calculos_x_tipo_tarifa(xajax.$("tarifa"+i).value,xajax.$("material"+i).value,i,xajax.$('origen'+i).value,xajax.$('tiro'+i).value,xajax.$('camion'+i).value,xajax.$("idviaje"+i).value,xajax.$("tara"+i).value,xajax.$("bruto"+i).value);
                });

            });
        </script>
    </head>

    <body >
        <div id="layout">
            <div id="encabezado_pagina" style="width:100%;">
                <img src="../../Imagenes/validaviajes/DocumentEdit.png" />
                Validaci&oacute;n de Viajes
            </div>
            <div align="center"> 
                <label ><font color="#000000" face="Trebuchet MS" style="font-size:12px;">C&Oacute;DIGO DE TICKET</font></label>
                <input type="text" id="codevalue" value="" >
                <input type="button" id="buttoncode" value="Buscar" >
            </div>
            
            <div class="detalle" id="tipos" style="width:100%; margin-top:20px; display:none">
                <span class="boton" onclick="xajax_muestra_viajes('v.Estatus=10')">
                    <img src="../../Imagenes/reload_24x24.gif" width="24" height="24" align="absbottom" />&nbsp;Viajes Completos
                </span>&nbsp;&nbsp;
                <span class="boton" onclick="xajax_muestra_viajes('v.Estatus=10')">
                    <img src="../../Imagenes/incompleto_24x24.gif" width="24" height="24" align="absbottom" />&nbsp;Viajes Incompletos
                </span>&nbsp;&nbsp;
                <span class="boton" onclick="xajax_muestra_viajes('v.Estatus=10')">
                    <img src="../../Imagenes/manules.gif" width="33" height="32" align="absbottom" />&nbsp;Viajes Manuales
                </span>
            </div>
            <div id="contenido" style="margin-top:15px">
                
            <table style="width:100%;"border="0" cellspacing="0" cellpadding="2">
            <?php 
                $i_general=1;
                $i_padre=1;
                
                while($v=$l->fetch($r)){ 
            ?>
            <tr>
                <td class="detalle">
                    <img src="../../Imagenes/validaviajes/Add.png" width="16" height="16" class="boton" onmouseover="this.src='../../Imagenes/validaviajes/Add.png'" onmouseout="this.src='../../Imagenes/validaviajes/Add.png'" onclick="cambiarDisplay('<?php echo $v["FechaO"]; ?>');cambiarDisplay('a<?php echo $v["FechaO"]?>');cambiarDisplay('r<?php echo $v["FechaO"]?>')" id="a<?php echo $v["FechaO"]?>" />
                    <img src="../../Imagenes/validaviajes/Remove.png" width="16" height="16" class="boton" onmouseover="this.src='../../Imagenes/validaviajes/Remove.png'" onmouseout="this.src='../../Imagenes/validaviajes/Remove.png'" onclick="cambiarDisplay('<?php echo $v["FechaO"]; ?>');cambiarDisplay('a<?php echo $v["FechaO"]?>');cambiarDisplay('r<?php echo $v["FechaO"]?>')" id="r<?php echo $v["FechaO"]?>" style="display:none" />
                    <img src="../../Imagenes/validaviajes/Calendar.png" width="16" height="16" align="absbottom" />
                    &nbsp;
                    <?php 
                        echo $v["Fecha"]; 
                    ?>
                    &nbsp;|&nbsp;
                    <?php 
                        echo $v["Total"]; 
                    ?> Viajes
                </td>
            </tr>
            <tr style="display:none" id="<?php echo $v["FechaO"]?>">
                <td>
                    <table style="width:97.5%;margin-left:2.5%"border="0" cellspacing="0" cellpadding="2">
                    <?php
                        $SQLs = "SELECT  t.IdTiro,t.Descripcion as Tiro,COUNT(v.IdTiro) AS Total FROM viajesnetos as v join tiros as t using (IdTiro) WHERE  v.FechaLlegada='".$v["FechaO"]."' AND (v.Estatus = 0 OR v.Estatus = 10 OR v.Estatus = 20 OR v.Estatus = 30 )AND v.IdProyecto = ".$_SESSION['Proyecto']." GROUP BY  t.IdTiro;";
                        $r_tiros=$l->consultar($SQLs);
	
                        while($v_tiros=$l->fetch($r_tiros)) { 
                    ?>
            <tr>
                <td class="detalle">
                    <img src="../../Imagenes/validaviajes/Add.png" width="16" height="16" class="boton" onmouseover="this.src='../../Imagenes/validaviajes/Add.png'" onmouseout="this.src='../../Imagenes/validaviajes/Add.png'" onclick="cambiarDisplay('<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>');cambiarDisplay('a<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>');cambiarDisplay('r<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>')" id="a<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>" />
                    <img src="../../Imagenes/validaviajes/Remove.png" width="16" height="16" class="boton" onmouseover="this.src='../../Imagenes/validaviajes/Remove.png'" onmouseout="this.src='../../Imagenes/validaviajes/Remove.png'" onclick="cambiarDisplay('<?php echo $v["FechaO"].$v_tiros["IdTiro"]; ?>');cambiarDisplay('a<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>');cambiarDisplay('r<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>')" id="r<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>" style="display:none" />
                    <img src="../../Imagenes/validaviajes/Enter.png" alt="c" width="16" height="16" align="absbottom" onclick="cambiarDisplay('<?php echo $v["FechaO"].$v_tiros["IdTiro"]; ?>')" />
                    &nbsp;
                    <?php 
                        echo $v_tiros["Tiro"]; 
                    ?>
                    &nbsp;|&nbsp;
                    <?php 
                        echo $v_tiros["Total"]; 
                    ?> Viajes
                </td>
            </tr>
            <tr style="display:none" id="<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>">
                <td>
                    <table style="width:97.5%;margin-left:2.5%"border="0" cellspacing="0" cellpadding="2">
                    <?php 
                        $SQLs = "SELECT  c.IdCamion as IdCamion,c.Economico as Camion, COUNT(v.IdViajeNeto) AS Total FROM viajesnetos as v join camiones as c using (IdCamion) WHERE  v.FechaLlegada='".$v["FechaO"]."' AND v.IdTiro=".$v_tiros["IdTiro"]." AND (v.Estatus = 0 OR v.Estatus = 10 OR v.Estatus = 20 OR v.Estatus = 30 ) AND v.IdProyecto = ".$_SESSION['Proyecto']." GROUP BY v.IdCamion;";
                        $r_camiones=$l->consultar($SQLs);

                        while($v_camiones=$l->fetch($r_camiones)) { 
                    ?>
                    <script>
                        var Arreglo_<?php echo $i_padre ?> = new Array();
                        var Arreglo_Procesar_<?php echo $i_padre ?> = new Array();
                    </script>
                    <tr>
                        <td class="detalle">            
                            <img src="../../Imagenes/validaviajes/Add.png" width="16" height="16" class="boton" onmouseover="this.src='../../Imagenes/validaviajes/Add.png'" onmouseout="this.src='../../Imagenes/validaviajes/Add.png'" onclick="cambiarDisplay('<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]; ?>');cambiarDisplay('a<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]; ?>');cambiarDisplay('r<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]; ?>')" id="a<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]; ?>" />
                            <img src="../../Imagenes/validaviajes/Remove.png" width="16" height="16" class="boton" onmouseover="this.src='../../Imagenes/validaviajes/Remove.png'" onmouseout="this.src='../../Imagenes/validaviajes/Remove.png'" onclick="cambiarDisplay('<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]; ?>');cambiarDisplay('a<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]; ?>');cambiarDisplay('r<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]; ?>')" id="r<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]; ?>" style="display:none" />
                            <img src="../../Imagenes/validaviajes/Cargo.png" alt="c" width="16" height="16" align="absbottom" onclick="cambiarDisplay('<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]; ?>')" />
                            &nbsp;
                            <?php 
                                echo $v_camiones["Camion"]; 
                            ?>
                            &nbsp;|&nbsp;
                            <?php 
                                echo $v_camiones["Total"]; 
                            ?> 
                            Viajes Registrados
                        </td>
                    </tr>
                    <tr style="display:none" id="<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]?>">
                        <td>
                            <div style="width:75%; overflow : auto;">
                            <table border="0" cellpadding="2" cellspacing="0" class="formulario" style="width:100%">
                                <tr class="Item">
                                    <td rowspan="2" align="center">
                                        #
                                    </td>
                                    <td rowspan="2" align="center">
                                        ?
                                    </td>
                                    <td rowspan="2" align="center">
                                        Hora Llegada
                                    </td>
                                    <td rowspan="2" align="center">
                                        <img src="../../Imagenes/validaviajes/Success.png" alt="" width="12" height="12" />
                                    </td>
                                    <td rowspan="2" align="center">
                                        <img src="../../Imagenes/validaviajes/Cancel.png" alt="" width="12" height="12" />
                                    </td>
                                    <td rowspan="2" align="center">
                                        m<sup>3</sup>
                                    </td>
                                    <td rowspan="2" align="center">
                                        Or&iacute;gen<br/>
                                        <?php 
                                            $lista_origenes_padre=$l->regresaSelect_evt("origen_padre".$i_padre,"distinct(origenes.IdOrigen), concat(origenes.Clave,'-',origenes.IdOrigen) AS Clave, origenes.Descripcion","origenes join rutas on (rutas.IdOrigen=origenes.IdOrigen AND rutas.Estatus=1 AND rutas.IdTiro=".$v_tiros["IdTiro"].") ","origenes.IdProyecto = ".$_SESSION["Proyecto"]." AND origenes.Estatus = 1","IdOrigen","Descripcion","desc","100px;visibility:hidden","1","0","1"," onChange='cambia_origen_child(Arreglo_".$i_padre.",\"".$i_padre."\")' ","","r");  
                                            echo $lista_origenes_padre;
                                        ?>
                                    </td>
                                    <td rowspan="2" align="center">
                                        Sindicato<br/>
                                    </td>
                                    <td rowspan="2" align="center">
                                        Empresa<br/>
                                    </td>
                                    <td rowspan="2" align="center">
                                        Material
                                    </td>
                                    <td rowspan="2" align="center">
                                        Tiempo
                                    </td>
                                    <td rowspan="2" align="center">
                                        Ruta
                                    </td>
                                    <td rowspan="2" align="center">
                                        Distancia (Km)
                                    </td>
                                    <td colspan="2" align="center">
                                        Peso (Kg)
                                    </td>
                                    <td colspan="3" align="center">
                                        Tarifa
                                    </td>
                                    <td rowspan="2" align="center">
                                        Importe
                                    </td>
                                    <td rowspan="2" align="center">
                                        Tipo Tarifa
                                    </td>
                                    <td rowspan="2" align="center">
                                        Tipo Fda.
                                    </td>
                                    <td rowspan="2" align="center" style="display:none">
                                        Horas Efectivas
                                    </td>
                                    <td rowspan="2" align="center" style="display:none">
                                        Cargador
                                    </td>
                                    <td rowspan="2" align="center">
                                        Imagenes
                                    </td>
                                </tr>
                                <tr class="Item">
                                    <td align="center">
                                        Tara
                                    </td>
                                    <td align="center">
                                        Bruto
                                    </td>
                                    <td align="center">
                                        1er Km
                                    </td>
                                    <td align="center">
                                        Km Sub.
                                    </td>
                                    <td align="center">
                                        Km Adc.
                                    </td>
                                </tr>
                                <?php 
                                    $SQLs = "
                                    SELECT
                                        v.IdViajeNeto as IdViaje,
                                        v.Estatus,
                                        v.HoraLlegada as Hora,
                                        v.code,
                                        if(fa.FactorAbundamiento is null,0.00,fa.FactorAbundamiento) as FactorAbundamiento,
                                        c.CubicacionParaPago as cubicacion,
                                        o.Descripcion as origen,
                                        o.IdOrigen as idorigen,
                                        m.Descripcion as material,
                                        m.IdMaterial as idmaterial,
                                        c.IdSindicato as IdSindicato,
                                        sin.descripcion as sindicato,
                                        c.IdEmpresa as IdEmpresa,
                                        emp.razonSocial as razonSocial,
                                        TIMEDIFF(
                                                (CONCAT(FechaLlegada,' ',HoraLlegada)),
                                                (CONCAT(FechaSalida,' ',HoraSalida))
                                                ) as tiempo_mostrar,
                                        ROUND((HOUR(TIMEDIFF(v.HoraLlegada,v.HoraSalida))*60)+(MINUTE(TIMEDIFF(v.HoraLlegada,v.HoraSalida)))+(SECOND(TIMEDIFF(v.HoraLlegada,v.HoraSalida))/60),2) AS tiempo,
                                        concat('R-',r.IdRuta) as ruta,
                                        r.TotalKM as distancia,
                                        r.IdRuta as idruta,
                                        tm.IdTarifa as tarifa_material,
                                        tm.PrimerKM as tarifa_material_pk,
                                        tm.KMSubsecuente as tarifa_material_ks,
                                        tm.KMAdicional as tarifa_material_ka,
                                        tr.IdTarifaTipoRuta as tarifa_ruta,
                                        if(r.TotalKM>=30,4.40,if(tr.PrimerKM is null,'- - -',tr.PrimerKM))  as tarifa_ruta_pk,
                                        if(r.TotalKM>=30,2.10,if(tr.KMSubsecuente is null,'- - -',tr.KMSubsecuente))  as tarifa_ruta_ks,
                                        if(r.TotalKM>=30,0.00,if(tr.KMAdicional is null,'- - -',tr.KMAdicional))  as tarifa_ruta_ka,
                                        cn.IdCronometria,
                                        cn.TiempoMinimo,
                                        cn.Tolerancia,
                                        if(cn.TiempoMinimo-cn.Tolerancia is null,0.0,cn.TiempoMinimo-cn.Tolerancia) as cronometria,
                                        if(r.TotalKM>=30,4.40*c.CubicacionParaPago,tr.PrimerKM*1*c.CubicacionParaPago) as ImportePK_R,
                                        if(r.TotalKM>=30,2.10*r.KmSubsecuentes*c.CubicacionParaPago,tr.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago) as ImporteKS_R,
                                        if(r.TotalKM>=30,0.00*r.KmAdicionales*c.CubicacionParaPago,tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago) as ImporteKA_R,
                                        if(r.TotalKM>=30,((4.40*c.CubicacionParaPago)+(2.10*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)),((tr.PrimerKM*1*c.CubicacionParaPago)+(tr.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago))) as ImporteTotal_Rs,
                                        if(if(r.TotalKM>=30,((4.40*c.CubicacionParaPago)+(2.10*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)),((tr.PrimerKM*1*c.CubicacionParaPago)+(tr.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago))) is null, '- - -',if(r.TotalKM>=30,((4.40*c.CubicacionParaPago)+(2.10*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)),((tr.PrimerKM*1*c.CubicacionParaPago)+(tr.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)))) as ImporteTotal_R,
                                        tm.PrimerKM*1*c.CubicacionParaPago as ImportePK_M,
                                        tm.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago as ImporteKS_M,
                                        tm.KMAdicional*r.KmAdicionales*c.CubicacionParaPago as ImporteKA_M,
                                        ((tm.PrimerKM*1*c.CubicacionParaPago)+(tm.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tm.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)) as ImporteTotal_M
                                    FROM
                                        viajesnetos as v 
                                        join camiones as c using(IdCamion) 
                                        left join origenes as o using(IdOrigen) 
                                        join materiales as m using(IdMaterial) 
                                        left join tarifas as tm on(tm.IdMaterial=m.IdMaterial AND tm.Estatus=1) 
                                        left join factorabundamiento as fa on (m.IdMaterial=fa.IdMaterial and fa.Estatus=1) 
                                        left join rutas as r on(v.IdOrigen=r.IdOrigen AND v.IdTiro=r.IdTiro AND r.Estatus=1) 
                                        left join tarifas_tipo_ruta as  tr on(tr.IdTipoRuta=r.IdTipoRuta AND tr.Estatus=1) 
                                        left join cronometrias as cn on (cn.IdRuta=r.IdRuta AND cn.Estatus=1)
                                        left join sindicatos as sin on (c.IdSindicato = sin.IdSindicato)
                                        left join empresas as emp on (c.IdEmpresa = emp.IdEmpresa)
                                    WHERE 
                                        (v.Estatus = 0 OR v.Estatus = 10 OR v.Estatus = 20 ) AND
                                        v.IdProyecto = ".$_SESSION['Proyecto']." AND
                                        v.IdCamion = ".$v_camiones["IdCamion"]." AND
                                        v.FechaLlegada = '".$v["FechaO"]."' AND
                                        v.IdTiro = ".$v_tiros["IdTiro"]." group by idviaje";
                                    $r_viajes=$l->consultar($SQLs);
                                    $i=1;

                                    while($v_viajes=$l->fetch($r_viajes)) { 

                                    $SQLs = "
                                        SELECT vn.imagen as imagen, vn.estado as estado, cat.descripcion as descripcion 
                                        FROM viajes_netos_imagenes vn
                                        INNER JOIN cat_tipos_imagenes cat on cat.id = vn.idtipo_imagen
                                        where idviaje_neto = ".$v_viajes["IdViaje"]."";

                                    $r_Fotos=$l->consultar($SQLs);

                                    echo "<script>";
                                    echo "var Fotos_". $v_viajes["IdViaje"] . "= new Array();";
                                    $count =  1;
                                    while($v_Foto=$l->fetch($r_Fotos)) { 

                                        
                                        $imagen = "<li><img ali='1' src='data:image/png;base64,".$v_Foto['imagen']."' alt='foto' title='" . $v_Foto['descripcion'] . "'  /></li>";
                                      
                                        echo 'Fotos_' . $v_viajes["IdViaje"] . '.push(["' . $v_Foto['estado'] . '","' . $imagen . '"]);';
                                       // echo 'console.log(Fotos_' . $v_viajes["IdViaje"] . '.length);';
                                        $count++;
                                    }
                                    echo '</script> <br>';

                                ?>
                                <script>
                                    Arreglo_Procesar_<?php echo $i_padre ?>.push('<?php echo $i_general; ?>');
                                </script>
                                <input name="tiro<?php echo $i_general; ?>" id="tiro<?php echo $i_general; ?>" type="hidden" value="<?php echo $v_tiros["IdTiro"]; ?>" />
                                <input name="camion<?php echo $i_general; ?>" id="camion<?php echo $i_general; ?>" type="hidden" value="<?php echo $v_camiones["IdCamion"]; ?>" />
                                <input name="idviaje<?php echo $i_general; ?>" id="idviaje<?php echo $i_general; ?>" type="hidden" value="<?php echo $v_viajes["IdViaje"]; ?>" />
                                
                                <tr name="code_<?php echo $v_viajes["code"]; ?>" id="code_<?php echo $v_viajes["code"]; ?>" >
                                    <td class="detalle">
                                        <?php echo $i ?>&nbsp;
                                    </td>
                                <td>
                                    <div id="imagen<?php echo $i_general; ?>">
                                        <img src="../../Imagenes/validaviajes/<?php if($v_viajes["idmaterial"]==''||$v_viajes["tarifa_material"]==''||$v_viajes["Estatus"]==10||($v_viajes["Estatus"]==0&&($v_viajes["tiempo"]==0||($v_viajes["tiempo"]<$v_viajes["cronometria"])))) echo "FlagRed"; else echo "FlagGreen"; ?>.png" 
                                        <?php
                                            if($v_viajes["tiempo"]==0&&$v_viajes["Estatus"]==0){ 
                                                echo "title='El viaje no puede ser registrado porque el tiempo del viaje es  0.00 min.'";  
                                            }else
                                                if($v_viajes["Estatus"]==0&&($v_viajes["tiempo"]==0||($v_viajes["tiempo"]<$v_viajes["cronometria"]))) {
                                                    echo "title='El viaje no puede ser registrado porque no cumple con los tiempos de cronometr&iacute;a de la ruta'";
                                                } 
                                                else if($v_viajes["idruta"]==''&&$v_viajes["Estatus"]==0) { 
                                                    echo "title='El viaje no puede ser registrado porque no existe una ruta entre su origen y destino'"; 
                                                } 
                                                else if($v_viajes["tarifa_material"]==''&&$v_viajes["idmaterial"]!='') 
                                                    echo "title='El viaje no puede ser registrado porque no hay una tarifa registrada para su material'";
                                                else if($v_viajes["Estatus"]==10) 
                                                    echo "title='El viaje no puede ser registrado porque debe seleccionar primero su origen'";
				
				?> width="16" height="16" class="bandera" id_viaje="<?php echo $v_viajes["IdViaje"]; ?>" />
                            </div>
                        </td>
                        <td>
                            <?php 
                                echo $v_viajes["Hora"];
                            ?>
                        </td>
                <td align="center">
                    <div id="ch<?php echo $i_general ?>">
                        <input type="checkbox" name="a<?php echo $i_general; ?>" id="a<?php echo $i_general; ?>" onclick="clic('r<?php echo $i_general; ?>')" <?php if($v_viajes["idmaterial"]==''||$v_viajes["tarifa_material"]==''||$v_viajes["Estatus"]==10||($v_viajes["Estatus"]==0&&($v_viajes["tiempo"]==0||($v_viajes["tiempo"]<$v_viajes["cronometria"])))) echo "disabled"; else echo "checked"; ?> style="cursor:pointer"/>
                    </div>
                </td>
                <td align="center">
                    <div id="nch<?php echo $i_general ?>">
                        <input type="checkbox" name="r<?php echo $i_general; ?>" id="r<?php echo $i_general; ?>"  <?php if($v_viajes["idmaterial"]==''||$v_viajes["tarifa_material"]==''||$v_viajes["Estatus"]==10||($v_viajes["Estatus"]==0&&($v_viajes["tiempo"]==0||($v_viajes["tiempo"]<$v_viajes["cronometria"])))){ echo "checked"; }?> onclick="clic('a<?php echo $i_general; ?>')" style="cursor:pointer"/>
                    </div>
                </td>
<!--    cubicación         -->
                <td align="center" class="detalle">
                    <?php //echo $v_viajes["cubicacion"] ?>
                     <input name="cubicacion1<?php echo $i_general; ?>" type="hidden"  id="cubicacion1<?php echo $i_general; ?>" style="width:25px" value="<?php echo $v_viajes['cubicacion'] ?>" readonly="readonly"/>
                    <input name="cubicacion<?php echo $i_general; ?>" type="text" class="cubicacion detalle" id="cubicacion<?php echo $i_general; ?>" style="width:25px" value="<?php echo $v_viajes['cubicacion'] ?>" contador="<?php echo $i_general; ?>" readonly="readonly"/>
                </td>
<!--    Origen          -->
                <td align="center" >                    
                    <span class="detalle">
                    <?php 
                        $lista_origenes=$l->regresaSelect_evt("origen".$i_general,"distinct(origenes.IdOrigen), concat(origenes.Clave,'-',origenes.IdOrigen) AS Clave, origenes.Descripcion","origenes join rutas on (rutas.IdOrigen=origenes.IdOrigen AND rutas.Estatus=1 AND rutas.IdTiro=".$v_tiros["IdTiro"].") ","origenes.IdProyecto = ".$_SESSION["Proyecto"]." AND origenes.Estatus = 1","IdOrigen","Descripcion","desc","100px","1","0","1","hidden",$v_viajes["idmaterial"],"r");  
                        echo $lista_origenes;
                    ?> 
                    <?php echo $v_viajes["origen"]; ?>
                    </span>
                </td>
<!--    Sindicato          -->
                <td align="center">
                    <?php 
                        $lista_sindicatos=$l->regresaSelect_evt("sindicato".$i_general,"IdSindicato, Descripcion, NombreCorto","sindicatos","Estatus = 1","IdSindicato","Descripcion","asc","150px","1","0","1","",$v_viajes["IdSindicato"],"r");  
                        echo $lista_sindicatos;
                    ?>
                </td>
<!--    Empresa          -->
                <td align="center">
                    <?php 
                        $lista_empresas=$l->regresaSelect_evt("empresa".$i_general,"IdEmpresa, razonSocial, RFC","empresas","Estatus = 1","IdEmpresa","razonSocial","asc","150px","1","0","1","",$v_viajes["IdEmpresa"],"r");  
                        echo $lista_empresas;
                    ?>
                </td>
<!--    Material          -->
                <td align="center">
                    <span class="detalle">
                        <input name="material<?php echo $i_general; ?>" id="material<?php echo $i_general; ?>" type="hidden" value="<?php echo $v_viajes["idmaterial"] ?>" />
                        <?php echo $v_viajes["material"] ?>
                    </span>
                </td>
<!--    Tiempo          -->
                <td align="center"><span class="detalle"><?php echo substr($v_viajes["tiempo_mostrar"],0,5); ?></span></td>
<!--    Ruta          -->
                <td align="center">
                    <span class="detalle">
                        <div id="rut<?php echo $i_general; ?>">
                            <?php echo $v_viajes["ruta"] ?>
                        </div>
                    </span>
                </td>
<!--    Distancia          -->
                <td align="center">
                    <span class="detalle">
                        <div id="dis<?php echo $i_general; ?>">
                            <?php echo $v_viajes["distancia"] ?>
                        </div>
                    </span>
                </td>
<!--    Tara          -->
                <td align="center" class="detalle">
                    <div id="dtara<?php echo $i_general; ?>">
                        <input name="tara<?php echo $i_general; ?>" type="text" class="monetario tipo_tarifa_p" id="tara<?php echo $i_general; ?>" style="width:45px" value="0.00" contador="<?php echo $i_general; ?>" />
                    </div>
                </td>
<!--    Bruto          -->
                <td align="center" class="detalle">
                    <div id="dbruto<?php echo $i_general; ?>">
                        <input name="bruto<?php echo $i_general; ?>" type="text" class="monetario tipo_tarifa_p" id="bruto<?php echo $i_general; ?>" style="width:45px" value="0.00" contador="<?php echo $i_general; ?>" />
                    </div>
                </td>
<!--    1er Km          -->
 		         <td align="center" class="detalle">
                    <div id="dpk<?php echo $i_general; ?>">
                        <?php echo number_format($v_viajes["tarifa_material_pk"],2) ?>
                    </div>
                </td>
<!--    Km sub.          -->
                <td align="center" class="detalle">
                    <div id="dks<?php echo $i_general; ?>"> 
                        <?php echo number_format($v_viajes["tarifa_material_ks"],2) ?>
                    </div>
                </td>
<!--    Km Adc          -->
                <td align="center" class="detalle">
                    <div id="dka<?php echo $i_general; ?>"> 
                        <?php echo number_format($v_viajes["tarifa_material_ka"],2) ?>
                    </div>
                </td>
<!--    Tipo Tarifa          -->
                <td align="center">
                    <span class="detalle">
                        <div id="imp<?php echo $i_general; ?>">
                            <?php echo number_format($v_viajes["ImporteTotal_M"],2) ?>
                        </div>
                    </span>
                </td>
<!--    Tipo Fda          -->
                <td align="center">
                    <div id="dtarifa<?php echo $i_general; ?>">
                        <select name="tarifa<?php echo $i_general; ?>" id="tarifa<?php echo $i_general; ?>"  class="tipo_tarifa" contador="<?php echo $i_general; ?>">
                            <option value="m">Material</option>
                            <option value="r">Ruta</option>  
                            <option value="p">Peso</option>
                        </select>
                    </div>
                </td>

                <td align="center">
                    <div id="dfda<?php echo $i_general; ?>">
                        <select name="fda<?php echo $i_general; ?>" id="fda<?php echo $i_general; ?>" >
	                    <option value="m">Material</option>
                            <option value="bm">Ban-Mat</option>
                        </select>
                    </div>
                </td>
                <td align="center" style="display:none">
                    <span class="Item1">
                        <input name="hef<?php echo $i_general; ?>" id="hef<?php echo $i_general; ?>" type="text" class="texto" onkeypress="onlyDigits(event,'decOK')"  size="2" maxlength="7"  />
                    </span>
                </td>
                <td align="center" style="display:none">
                    <?php 
                        $lista_tipo_rutas=$l->regresaSelect_evt("cr".$i_general,"IdMaquinaria, Economico","maquinaria","Estatus=1","IdMaquinaria","Economico","desc","70px","1","0","1","","","r");  
                        echo $lista_tipo_rutas;
                    ?>
                </td>
                <td align="center">
                    <img src=<? if( $count<> 1){echo"'../../Imagenes/validaviajes/foto.png'  onclick='Mostrar_Fotos(Fotos_" . $v_viajes["IdViaje"] . "); //verFotos(" . $v_viajes["IdViaje"] . ");  '";}else{echo"'../../Imagenes/validaviajes/Foto_nula.png' title='Sin Fotografias'";}?>   width="16" height="16" id="fotos<?php echo $i_general; ?>" name="fotos<?php echo $i_general; ?>" class="fotos" id_viaje="<?php echo $v_viajes["IdViaje"]; ?>"   />

                <td/>
            </tr>
                <?php 
                    $i_general++; $i++;}
                ?>
            <tr>
                <td colspan="20" align="right">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="20" align="right">
                    <input name="button" type="submit" class="boton" id="button" value="Validar Viajes" onclick="prepara_registra_viajes(Arreglo_Procesar_<?php echo $i_padre ?>)"/>
                </td>
            </tr>           
        </table>
    </td>
    </tr>
          <?php $i_padre++; } ?>
        </table></td>
      </tr>
      <?php  } ?>
    </table>
    </div>
    </td>
  </tr>
  <?php }  ?>
</table>
</div>
</div>

<div id="dialog" title="Imagen del Viaje">
  <p>Grupo Hermes Infraestructura</p>
</div>

<div id="nuevaCubi" title="Nueva cubicaci&oacute;n">
</div>

</body>
<script src="../../Clases/Js/Cajas.js"></script>
<script language="javascript" src="../../Clases/Js/Genericas.js"></script>
<script type="text/javascript" src="../../Clases/Js/MuestraLoad.js"></script>
<script>
    function crea_arreglo(nombre){

    }

    function cambia_origen_child(arreglo,i_padre){

            for(o=0;o<arreglo.length;o++)
            {

                    xajax_calculos_x_tipo_tarifa(document.getElementById("tarifa"+arreglo[o]).value,document.getElementById("material"+arreglo[o]).value,arreglo[o],			     	document.getElementById("origen_padre"+i_padre).value,document.getElementById("tiro"+arreglo[o]).value,document.getElementById("camion"+arreglo[o]).value,document.getElementById('idviaje'+arreglo[o]).value,document.getElementById('tara'+arreglo[o]).value,document.getElementById('bruto'+arreglo[o]).value);
                    document.getElementById("origen"+arreglo[o]).value=document.getElementById("origen_padre"+i_padre).value;
            }
    }
    function clic(i){
            document.getElementById(i).checked=false;
    }

    function prepara_registra_viajes(arreglo){ 

        for(o=0;o<arreglo.length;o++){
            try{
                    accion=(document.getElementById('a'+arreglo[o]).checked)?1:(document.getElementById('r'+arreglo[o]).checked)?0:'n';
                            horas_efectivas=(document.getElementById('hef'+arreglo[o]).value=='')?0.00:document.getElementById('hef'+arreglo[o]).value;
                            maquinaria=(document.getElementById('cr'+arreglo[o]).value=='A99')?0:document.getElementById('cr'+arreglo[o]).value;
                            origen=(document.getElementById('origen'+arreglo[o]).value=='A99')?0:document.getElementById('origen'+arreglo[o]).value;
                            sindicato=(document.getElementById('sindicato'+arreglo[o]).value=='A99')?0:document.getElementById('sindicato'+arreglo[o]).value;
                            empresa=(document.getElementById('empresa'+arreglo[o]).value=='A99')?0:document.getElementById('empresa'+arreglo[o]).value;
                            id_viaje_neto=document.getElementById('idviaje'+arreglo[o]).value;
                            tarifa=document.getElementById('tarifa'+arreglo[o]).value;
                            fda=document.getElementById('fda'+arreglo[o]).value;
                            tara=document.getElementById('tara'+arreglo[o]).value;
                            bruto=document.getElementById('bruto'+arreglo[o]).value;
                            cubiNueva=document.getElementById('cubicacion'+arreglo[o]).value;
                            cubiOriginal=document.getElementById('cubicacion1'+arreglo[o]).value;

            }catch(e){accion='n'}

            if(accion!='n')
                xajax_registra_viaje(arreglo[o],accion,id_viaje_neto,maquinaria,horas_efectivas,origen,sindicato,empresa,tarifa,fda,tara,bruto,cubiNueva,cubiOriginal);
            }

    }
    /*
    $("img.bandera").off().on("click", function(){
        id_viaje = $(this).attr("id_viaje");
        $("#dialog").html('<div style="margin:0 auto; overflow:hidden"><img width="640" height="480" src="http://sca.grupohi.mx/imagenViaje.php?idviajeneto='+id_viaje+'" /></div>');
          $( "#dialog" ).dialog({
                modal: true,
                autoOpen: false,
                close: function(event, ui)
                        {
                            //$(this).remove();
                        },
                width: 650
            });
            $( "#dialog" ).dialog("open");
    });
    */
    function verFotos(idviaje){
        url = "VerFotos.php?idviajeneto='" + idviaje+"'";
       // aler(url);
        window.open(url, "nuevo", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no")

    }
</script>
<p id="demo"></p>
<script type="text/javascript">

    function Mostrar_Fotos(array){
       //alert(array.length);
       agrupar= "";
       for (i=0; i< array.length; i++){
            agrupar = agrupar + array[i][1];
        }
        agrupar = "<ul class='bxslider'>" + agrupar + "</ul>";
            $("#dialog").html('<div style="margin:0; overflow:hidden">' + agrupar + '</div>');
                $( "#dialog" ).dialog({
                modal: true,
                autoOpen: false,
                close: function(event, ui)
                        {
                            //$(this).remove();
                        },
                 width:800 
            });
                var height = $( "#dialog" ).dialog( "option", "height" );
                $( "#dialog" ).dialog( "option", "height", 600 );
            $( "#dialog" ).dialog("open")

            $('.bxslider').bxSlider({
        mode: 'fade',
        captions: true
    });
    }

    $("#buttoncode").click(function(){

        if($("#codevalue").val() != ""){
            id = '#code_'+$("#codevalue").val();
            if ( $(id).length > 0) {
                trs = $(id).parents("tr");
                $.each(trs, function(i,v){$(this).css("display","block");})

                $(id).css('background-color', '#82E0AA');setTimeout(function(){
                    $(id).css('background-color', '');
                }, 2000);
            }
            else{
                alert("El Ticket no existe!!");    
            }
        }
        else{
            alert("Escribir Ticket!!");
        }

    });

    $("#codevalue").change(function(){
        if($("#codevalue").val() != ""){
            id = '#code_'+$("#codevalue").val();
            if ( $(id).length > 0) {
                trs = $(id).parents("tr");
                $.each(trs, function(i,v){$(this).css("display","block");})

                $(id).css('background-color', '#82E0AA');setTimeout(function(){
                    $(id).css('background-color', '');
                    $("#codevalue").val('');
                }, 2000);
            }
            else{
                alert("El Ticket no existe!!");    
            }
        }
        else{
            alert("Escribir Ticket!!");
        }

    });

    $(".cubicacion").click(function(){
        value  = $(this).val();
        cubiAnt = $(this).attr("id");
        input = '<input type="text" value="' + value + '" id="NueCubi" style="width:25px" /><br><br> <input type="button" id="AceptaCubica" value="Aceptar" onclick="Acepta('+ cubiAnt+');">'; 
        div = '<div style="margin:0 auto; overflow:hidden" align="center"><br>Nueva Cubicaci&oacute;n: ' + input + '</div>';
        $("#nuevaCubi").html(div);
          $( "#nuevaCubi" ).dialog({
                modal: true,
                autoOpen: false,
                width: 350
            });
        $( "#nuevaCubi" ).dialog("open");
    });

    function Acepta(id){
        $("#nuevaCubi" ).dialog("close");
        $(id).val($('#NueCubi').val());
    }

</script>

<style type="text/css">
        .cubicacion {
            border: rgba(0,0,0,0);
            text-decoration: underline;
            text-align:right;
            cursor: pointer;
        }
</style>

</html>
