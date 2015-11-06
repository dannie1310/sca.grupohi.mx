<?php
session_start();
if(isset($_SESSION["IdUsuarioAc"])){
require("../inc/php/conexiones/SCA.php");
$SCA=SCA::getConexion();
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Topografia Mensual Por Material .- SCA</title>
		<link href="../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="jquery-1.6.4.js"></script>
		<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
		  zoomType: 'xy'
            },
            title: {
                text: 'Topografias'
            },
	     subtitle: {
                text: 'Mensual'
            },
            xAxis: {
                //categories: ['Apples', 'Oranges', 'Pears', 'Bananas', 'Plums']
				categories: [
							 <?php
							 $qmeses = "select distinct YEAR(Fecha),MONTH(Fecha),
										concat(
										if(MONTH(Fecha)=1,'Enero',
										if(MONTH(Fecha)=2,'Febrero',
										if(MONTH(Fecha)=3,'Marzo',
										if(MONTH(Fecha)=4,'Abril',
										if(MONTH(Fecha)=5,'Mayo',
										if(MONTH(Fecha)=6,'Junio',
										if(MONTH(Fecha)=7,'Julio',
										if(MONTH(Fecha)=8,'Agosto',
										if(MONTH(Fecha)=9,'Septiembre',
										if(MONTH(Fecha)=10,'Octubre',
										if(MONTH(Fecha)=11,'Noviembre',
										if(MONTH(Fecha)=12,'Diciembre',''
										))))))))))))
										,' ',YEAR(Fecha))
										  as Fecha from topografias order by YEAR(Fecha),MONTH(Fecha)";
							  $rmeses = $SCA->consultar($qmeses);
							  $nmeses = $SCA->affected();
							  $n=0;
							  while($vmeses = $SCA->fetch($rmeses)){
								  if($n==$nmeses){
									  echo '"'.$vmeses["Fecha"].'"';
									  }else{
										  echo '"'.$vmeses["Fecha"].'",';
										  }
								  }
							 ?>
							 ],
				title:{
					text:''
					}
            },
			yAxis: {
            title: {
                text: 'Volumen'
            }
        },
            tooltip: {
                /*formatter: function() {
                    var s;
                    if (this.point.name) { // the pie chart
                        s = ''+
                            this.point.name +': '+ this.y +' m3';
                    } else {
                        s = ''+
                            this.x  +': '+ this.y;
                    }
                    return s;
                }*/
		crosshairs: true,
		formatter: function() {
                    var s;
                   
                        s = ''+
                        this.x  +'<br />'+this.series.name+':<strong>'+ Highcharts.numberFormat(this.y, 2)+'m<sup>3</sup></strong>';
                    
                    return s;
                }

		
            },
            labels: {
                items: [{
                    html: '',
                    style: {
                        left: '250px',
                        top: '-14px',
                        color: 'black'
                    }
                }]
            },
            series: [/*{
                type: 'column',
                name: 'Jane',
                data: [3, 2, 1, 3, 4, 6]
            }, {
                type: 'column',
                name: 'John',
                data: [2, 3, 5, 7, 6, 7]
            }, {
                type: 'column',
                name: 'Joe',
                data: [4, 3, 3, 9, 0, 8]
            }, */
			<?php
			$qmateriales = "select distinct(t.IdMaterial) as IdMaterial,m.Descripcion from topografias as t left join materiales as m on m.IdMaterial = t.IdMaterial order by IdMaterial";
			$rmateriales = $SCA->consultar($qmateriales);
			while($vmateriales=$SCA->fetch($rmateriales)){
				?>
				{
					type: 'column',
					name:'<?php echo $vmateriales["Descripcion"]; ?>',
					data: [
						   <?php
						   $qfechas ="select distinct MONTH(Fecha) as Mes,YEAR(Fecha) as Anio from topografias group by Year(Fecha),Month(Fecha) order by Year(Fecha),Month(Fecha);";
						   $rfechas = $SCA->consultar($qfechas);
						   $nfechas = $SCA->affected();
						   $m=0;
						   while($vfechas = $SCA->fetch($rfechas)){
							   $qcantidades = "select if(sum(Parcial) is null,'0.00',sum(Parcial)) as Total from topografias where MONTH(Fecha)='".$vfechas['Mes']."' AND YEAR(Fecha)='".$vfechas['Anio']."' And IdMaterial='".$vmateriales['IdMaterial']."'";
							   $rcantidades = $SCA->consultar($qcantidades);
							   $vcantidades = $SCA->fetch($rcantidades);
							   if($m==$nfechas){
								   echo $vcantidades['Total'];
								   }else{
									   echo $vcantidades['Total'].',';
									   }
							   $m++;
							   }
						   ?>
						   ]
					},
				<?php
				}
			?>
			/*{
                type: 'line',
                name: 'Acumulado MATERIAL SCA 01',
                data: [0, 0, 1000, 1222, 1222, 2079]
				//data: []
            }, aqui iria el ciclo*/
			<?php
			$qmateriales = "select distinct(t.IdMaterial) as IdMaterial,m.Descripcion from topografias as t left join materiales as m on m.IdMaterial = t.IdMaterial order by IdMaterial";
			$rmateriales = $SCA->consultar($qmateriales);
			while($vmateriales=$SCA->fetch($rmateriales)){
				?>
				{
                type: 'line',
                name: 'Acumulado <?php echo $vmateriales["Descripcion"]?>',
                data: [
					    <?php
						   $qfechas ="select distinct MONTH(Fecha) as Mes,YEAR(Fecha) as Anio from topografias group by Year(Fecha),Month(Fecha) order by Year(Fecha),Month(Fecha);";
						   $rfechas = $SCA->consultar($qfechas);
						   $nfechas = $SCA->affected();
						   $m=0;
						   $acumulado=0;
						   while($vfechas = $SCA->fetch($rfechas)){
							   $qcantidades = "select if(sum(Parcial) is null,'0.00',sum(Parcial)) as Total from topografias where MONTH(Fecha)='".$vfechas['Mes']."' AND YEAR(Fecha)='".$vfechas['Anio']."' And IdMaterial='".$vmateriales['IdMaterial']."'";
							   $rcantidades = $SCA->consultar($qcantidades);
							   $vcantidades = $SCA->fetch($rcantidades);
							   $acumulado = $acumulado+$vcantidades['Total'];
							   if($m==$nfechas){
								   echo $acumulado;
								   }else{
									   echo $acumulado.',';
									   }
							   
							   $m++;
							   }
						   ?>
					   ]
				//data: []
            	},
				<?php
				}
			?>
			/*, {
                type: 'pie',
                name: 'Total consumption',
                data: [{
                    name: 'Jane',
                    y: 13,
                    color: '#4572A7' // Jane's color
                }, {
                    name: 'John',
                    y: 23,
                    color: '#AA4643' // John's color
                }, {
                    name: 'Joe',
                    y: 19,
                    color: '#89A54E' // Joe's color
                }],
                center: [100, 80],
                size: 100,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }*/]
        });
    });
    
});
		</script>
	</head>

	<body>
<script src="highcharts.js"></script>
<script src="exporting.js"></script>
<table width="1000px" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td background="../Imgs/banner.jpg" style="width:1000px; height:60px;"><br />
        <br />
            </tr>
    <tr bgcolor="#000;">
      <td  class="Bienvenida"><div id="bienvenida"><?php echo "BIENVENIDO: ".$_SESSION['Descripcion'].", PROYECTO: ".$_SESSION["DescripcionProyecto"]; ?></div>
        </td>
    </tr>
  </table><br /><br />

<div id="container" style="width:98%; height: 70%; margin: 0 auto"></div>

	</body>
</html>
<?php
}else{
	session_destroy();
			//header("Location:http://localhost/SAC/Login.php");
			echo"<script lenguage=javascript type=text/javascript>
						window.location.replace('../Login.php');
					 </script>;";
	}
?>
