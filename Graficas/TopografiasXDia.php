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
		<title>Topografia Diaria Por Material .- SCA</title>

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
                text: 'Diario'
            },

            xAxis: {
                //categories: ['Apples', 'Oranges', 'Pears', 'Bananas', 'Plums']
				categories: [
							 <?php
							 $qfechas = "select distinct DATE_FORMAT(Fecha,'%d-%m-%Y') as Dia from topografias order by Fecha";
							  $rfechas = $SCA->consultar($qfechas);
							  $nfechas = $SCA->affected();
							  $n=1;
							  while($vfechas = $SCA->fetch($rfechas)){
								  if($n==$nfechas){
									  echo '"'.$vfechas["Dia"].'"';
									  }else{
										  echo '"'.$vfechas["Dia"].'",';
										  }
								$n++;
								  }
							?>
							 
							 ],
				labels: {
                rotation: -45,
                                align: 'right',
                                style: {
                                    font: 'normal 10px Calibri'
                                }            },
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
					name:'<?php echo $vmateriales['Descripcion']; ?>',
					data: [
						   <?php
						   $qfechas = "select distinct Fecha from topografias order by Fecha";
						   $rfechas = $SCA->consultar($qfechas);
						   $nfechas = $SCA->affected();
						   $m=0;
						   while($vfechas = $SCA->fetch($rfechas)){
							   $qparciales = "select * from topografias where Fecha='".$vfechas['Fecha']."' and IdMaterial = '".$vmateriales['IdMaterial']."'";
							   $rparciales = $SCA->consultar($qparciales);
							   $vparciales = $SCA->fetch($rparciales);
							   if($vparciales['Parcial']>0){
								   $parcial = $vparciales['Parcial'];
								   }else{
									   $parcial = '0.00';
									   }
							   if($m==$nfechas){
								   echo $parcial;
								   }else{
									   echo $parcial.',';
									   }
							   }
						   ?>
						   ]
					},
				<?php
				}
			?>
				/*{
					type: 'column',
					name:'Material SCA 01',
					data: [5,7,3,5,2,5,7,4,7,6]
					},
				{
					type: 'column',
					name:'Material SCA 01',
					data: [5,3,8,1,5,4,6,7,6,7]
					},*/
				
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
                name: 'Acumulado <?php echo $vmateriales['Descripcion']?>',
                data: [
					    <?php
						$qfechas = "select distinct Fecha from topografias order by Fecha";
						$rfechas = $SCA->consultar($qfechas);
						$o=0;
						$acumulado=0;
						while($vfechas = $SCA->fetch($rfechas)){
							$qcantidades = "select if(sum(Parcial) is null,'0.00',sum(Parcial)) as Total from topografias where  Fecha='".$vfechas['Fecha']."' And IdMaterial='".$vmateriales['IdMaterial']."'";
							   $rcantidades = $SCA->consultar($qcantidades);
							   $vcantidades = $SCA->fetch($rcantidades);
							   $acumulado = $acumulado+$vcantidades['Total'];
							   if($o==$nfechas){
								   echo $acumulado;
								   }else{
									   echo $acumulado.',';
									   }
							   
							   $o++;
							}
						?>
					   ]
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
<link href="../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
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
