<?php
session_start();

require('../../Clases/PDF/fpdf.php');
include("../../inc/php/conexiones/SCA.php");
include("../../Clases/Funciones/FuncionesValidaViajes.php");

$Anio=substr($_POST["Semana"],0,4);
$Semana=substr($_POST["Semana"],4,2);
$proyecto=$_REQUEST["Proyecto"];

//Obtenemos el Rango de Fechas que Compone la Semana a Consultar
$Link=SCA::getConexion();
$SQL="SELECT DISTINCT viajes.FechaSalida, weekday(viajes.FechaSalida) AS Dia FROM viajes WHERE viajes.IdProyecto = ".$proyecto." AND weekofyear(viajes.FechaSalida) = ".$Semana." AND year(viajes.FechaSalida) = ".$Anio." ORDER BY viajes.FechaSalida;";
//echo "<br><br>".$SQL;
$Result=$Link->consultar($SQL);
//$Link->cerrar();

$Contador=0;
while($Row=mysql_fetch_array($Result))
{
	$DiasTrabajados[$Contador][1]=$Row["FechaSalida"];	//Fecha Completa
	$DiasTrabajados[$Contador][2]=$Row["Dia"];	//Dia de la Semana 0=Lunes
	$Contador=$Contador+1;
}
//Completamos a que sean 7 Dias por semana
	for($a=0;$a<7;$a++)
	{
		for($b=0;$b<count($DiasTrabajados);$b++)
		{
			if($a==$DiasTrabajados[$b][2])
			{
				$DiasDeLaSemana[$a]=$DiasTrabajados[$b][1];
			}
		}

		if($DiasDeLaSemana[$a]=="")
		{
			$DiasDeLaSemana[$a]="0000-00-00";
		}

		//echo "<br>Día ".$a." .- ".$DiasDeLaSemana[$a];
	}

	//Armamos un Arreglo con las Fechas en Formato DD-MM-YYY
	for($z=0;$z<=count($DiasDeLaSemana);$z++)
	{
		$DiasDeLaSemanaMX[$z]=FechaMX($DiasDeLaSemana[$z]);
	}



class PDF extends FPDF
{
	//Cabecera de página
	function Header()
	{
	    //Logo
		    $this->Image('../../Imgs/LogosFormatos/LogoPeninsular.jpg',1,.8,2.5,2.5);

			//Establecemos Tamaño, Color y Tipo de Letra
			$this->SetFont('Times','BI',10);
			$this->SetTextColor(0,0,0);
			$this->SetFillColor(255,255,255);

		    //Título
			$this->Cell(3.5,.5,' ',0,0,'L');
		    $this->Cell(16,.5,'CONTROL DIARIO DE ACARREOS',0,1,'L');
			$this->Cell(3.5,.5,' ',0,0,'L');
			$this->Cell(16,.5,'LA PENINSULAR COMPAÑÍA CONSTRUCTORA, S.A. DE C.V.',0,1,'L');
			$this->Cell(3.5,.5,' ',0,0,'L');
			$this->Cell(16,.5,'OBRA: LIBRAMIENTO AEROPUERTO MORELIA',0,1,'L');
			$this->Cell(3.5,.5,' ',0,0,'L');
			$this->Cell(16,.5,'REPORTE POR PERÍODO DE MOVIMIENTOS DE TIERRA POR TIRO',0,1,'L');
			$this->Cell(3.5,.5,' ',0,0,'L');

			//Arial bold 15
		    $this->SetFont('Times','BI',7);
			$this->Cell(16,.5,'FECHA DE IMPRESIÓN '.date("d-m-Y")."/".date("H:i:s",time()),0,1,'R');

		    //Salto de línea
		    $this->Ln(1);

			//Establecemos Tamaño, Color y Tipo de Letra
			$this->SetFont('Times','BI',8);
			$this->SetTextColor(0,0,0);
			$this->SetFillColor(255,255,255);
	}

	//Pie de página
	function Footer()
	{
	    //Posición: a 1,5 cm del final
	    $this->SetY(-2.3);

		//Establecemos Tamaño, Color y Tipo de Letra
		$this->SetFont('Times','BI',8);
		$this->SetTextColor(255,255,255);
		$this->SetFillColor(0,0,0);

	    //Número de página
	    $this->Cell(6.5,.3,'CHECADOR',1,0,'C',1);
	    $this->Cell(6.5,.3,'Vo. Bo.',1,0,'C',1);
	    $this->Cell(6.5,.3,'ECO DEL EQUIPO DE CARGA',1,1,'C',1);
	    $this->Cell(6.5,1.5,' ',1,0,'R');
	    $this->Cell(6.5,1.5,' ',1,0,'R');
	    $this->Cell(6.5,1.5,' ',1,1,'R');

		//Establecemos Tamaño, Color y Tipo de Letra
		$this->SetFont('Times','BI',8);
		$this->SetTextColor(0,0,0);
		$this->SetFillColor(255,255,255);

	    $this->Cell(19.5,.4,'Página '.$this->PageNo().'/{nb}',0,1,'R');

		//Establecemos Tamaño, Color y Tipo de Letra
		$this->SetFont('Times','BI',8);
		$this->SetTextColor(0,0,0);
		$this->SetFillColor(255,255,255);
	}
}

//Creación del objeto de la clase heredada
	$pdf=new PDF('P','cm','Letter');
	$pdf->AliasNbPages();
	$pdf->AddPage();

//Llenamos los Datos del Reporte

	//Nos Traemos los Datos Necesarios

		//Traemos los Tiros Involucrdos para la semana en cuestion
			$Link=SCA::getConexion();
			$SQL="SELECT tiros.Descripcion,viajes.IdTiro FROM viajes, tiros WHERE viajes.IdTiro = tiros.IdTiro AND viajes.IdProyecto = ".$proyecto." AND weekofyear(viajes.FechaSalida) = ".$Semana." AND year(viajes.FechaSalida)=".$Anio." GROUP BY tiros.Descripcion;";
			//echo "<br><br>".$SQL;
			$Result=$Link->consultar($SQL);
			//$Link->cerrar();

			$Contador=1;
			while($Row=mysql_fetch_array($Result))
			{
				$Tiros[$Contador][1]=$Row["Descripcion"];	//Descripción del Tiro
				$Tiros[$Contador][2]=$Row["IdTiro"];		//Id Del Tiro
				$Contador=$Contador+1;
			}

		//Nos Traemos los Camiones que participaron en el Tiro
			$Contador=1;

			for($a=1;$a<=count($Tiros);$a++)
			{
				//$Link=SCA::getConexion();
				$SQL="SELECT DISTINCT viajes.IdCamion, camiones.Economico, camiones.CubicacionParaPago FROM viajes, camiones WHERE camiones.IdCamion = viajes.IdCamion AND viajes.IdProyecto = ".$proyecto." AND viajes.FechaSalida IN ('".$DiasDeLaSemana[0]."','".$DiasDeLaSemana[1]."','".$DiasDeLaSemana[2]."','".$DiasDeLaSemana[3]."','".$DiasDeLaSemana[4]."','".$DiasDeLaSemana[5]."','".$DiasDeLaSemana[6]."') AND viajes.IdTiro = ".$Tiros[$a][2]." AND year(viajes.FechaSalida)=".$Anio." ORDER BY camiones.Economico;";
				//echo "<br><br>".$SQL;
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();


				$TotalViajesConcentradoViajes=0;
				while($Row=mysql_fetch_array($Result))
				{
					$ConcentradoViajes[$Contador][15]=$Tiros[$a][2];
					$ConcentradoViajes[$Contador][1]=$Row["IdCamion"];					//Id del Camion
					$ConcentradoViajes[$Contador][2]=$Row["Economico"];					//Economico del Camion
					$ConcentradoViajes[$Contador][3]=$Row["CubicacionParaPago"];		//Cubicacion del Camion
					$ConcentradoViajes[$Contador][4]=RegresaTotalViajesXDiaXTiro($proyecto,$DiasDeLaSemana[0],$Tiros[$a][2],$ConcentradoViajes[$Contador][1]);		//Total de Viajes para la Fecha 1 de la Semana
					$ConcentradoViajes[$Contador][5]=RegresaTotalViajesXDiaXTiro($proyecto,$DiasDeLaSemana[1],$Tiros[$a][2],$ConcentradoViajes[$Contador][1]);		//Total de Viajes para la Fecha 2de la Semana
					$ConcentradoViajes[$Contador][6]=RegresaTotalViajesXDiaXTiro($proyecto,$DiasDeLaSemana[2],$Tiros[$a][2],$ConcentradoViajes[$Contador][1]);		//Total de Viajes para la Fecha 3 de la Semana
					$ConcentradoViajes[$Contador][7]=RegresaTotalViajesXDiaXTiro($proyecto,$DiasDeLaSemana[3],$Tiros[$a][2],$ConcentradoViajes[$Contador][1]);		//Total de Viajes para la Fecha 4 de la Semana
					$ConcentradoViajes[$Contador][8]=RegresaTotalViajesXDiaXTiro($proyecto,$DiasDeLaSemana[4],$Tiros[$a][2],$ConcentradoViajes[$Contador][1]);		//Total de Viajes para la Fecha 5 de la Semana
					$ConcentradoViajes[$Contador][9]=RegresaTotalViajesXDiaXTiro($proyecto,$DiasDeLaSemana[5],$Tiros[$a][2],$ConcentradoViajes[$Contador][1]);		//Total de Viajes para la Fecha 6 de la Semana
					$ConcentradoViajes[$Contador][10]=RegresaTotalViajesXDiaXTiro($proyecto,$DiasDeLaSemana[6],$Tiros[$a][2],$ConcentradoViajes[$Contador][1]);		//Total de Viajes para la Fecha 7 de la Semana
					$ConcentradoViajes[$Contador][11]=0;
					//Total de Viajes por Semana del Camion
					$ConcentradoViajes[$Contador][11]=$ConcentradoViajes[$Contador][4]+$ConcentradoViajes[$Contador][5]+$ConcentradoViajes[$Contador][6]+$ConcentradoViajes[$Contador][7]+$ConcentradoViajes[$Contador][8]+$ConcentradoViajes[$Contador][9]+$ConcentradoViajes[$Contador][10];
					//Volumen por semana del Camion
					$ConcentradoViajes[$Contador][12]=($ConcentradoViajes[$Contador][3]*$ConcentradoViajes[$Contador][11]);
					//Importe de los Viajes por semana del camion
					$ConcentradoViajes[$Contador][13]=RegresaImporteSumaViajesXTiroXFecha($proyecto,$Semana,$Tiros[$a][2],$ConcentradoViajes[$Contador][1]);	//Importe Sin Formato
					$ConcentradoViajes[$Contador][16]=number_format($ConcentradoViajes[$Contador][13],2,'.',',');	//Importe por camión con Formato
					$ConcentradoViajes[$Contador][17]=number_format($ConcentradoViajes[$Contador][12],2,'.',',');	//Volumen en m3 Movidos por camion con formato
					$Contador=$Contador+1;
				}
			}


	for($z=1;$z<=count($Tiros);$z++)
	{

		//Establecemos Tamaño, Color y Tipo de Letra
		$pdf->SetFont('Times','B',8);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFillColor(0,0,0);

		//Llenamos los Tiros Trabajados
		$pdf->Cell(19.5,.4,'TIRO: '.$Tiros[$z][1],0,1,'L',1);

		//Nos Traemos el Trabajo Realizado por Tiro

			//Establecemos Tamaño, Color y Tipo de Letra
			$pdf->SetFont('Times','B',8);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(204,204,204);

			//Detalle de Trabajo por Tiro
			$pdf->Cell(4,.5,'DATOS CAMIÓN',1,0,'C',1);
			$pdf->Cell(10.5,.5,'Semana '.$Semana,1,0,'C',1);
			$pdf->Cell(3,.5,'TOTALES SEMANA',1,0,'C',1);
			$pdf->Cell(2,.5,' ',1,1,'C',1);

			$pdf->Cell(2,.5,'ECONÓMICO',1,0,'C',1);
			$pdf->Cell(2,.5,'CAPACIDAD',1,0,'C',1);
			$pdf->Cell(1.5,.5,$DiasDeLaSemanaMX[0],1,0,'C',1);
			$pdf->Cell(1.5,.5,$DiasDeLaSemanaMX[1],1,0,'C',1);
			$pdf->Cell(1.5,.5,$DiasDeLaSemanaMX[2],1,0,'C',1);
			$pdf->Cell(1.5,.5,$DiasDeLaSemanaMX[3],1,0,'C',1);
			$pdf->Cell(1.5,.5,$DiasDeLaSemanaMX[4],1,0,'C',1);
			$pdf->Cell(1.5,.5,$DiasDeLaSemanaMX[5],1,0,'C',1);
			$pdf->Cell(1.5,.5,$DiasDeLaSemanaMX[6],1,0,'C',1);
			$pdf->Cell(1.5,.5,'VIAJES',1,0,'C',1);
			$pdf->Cell(1.5,.5,'M3',1,0,'C',1);
			$pdf->Cell(2,.5,'TOTAL',1,1,'C',1);

		//Lenamos Los Concentrados de los Viajes Trabajados por Tiro
			$TotalViajesConcentradoViajes=0;
			$TotalVolumenConcentradoViajes=0;
			$TotalImporteConcentradoViajes=0;

			for($a=1;$a<=count($ConcentradoViajes);$a++)
			{

				//echo "Entro al FOR<br>";
				if ($ConcentradoViajes[$a][15]==$Tiros[$z][2])
				{

					//echo "Entro al IF <br>";
					//Establecemos Tamaño, Color y Tipo de Letra
					$pdf->SetFont('Times','B',8);
					$pdf->SetTextColor(0,0,0);
					$pdf->SetFillColor(255,255,255);

					$pdf->Cell(2,.5,$ConcentradoViajes[$a][2],1,0,'C',1);
					$pdf->Cell(2,.5,$ConcentradoViajes[$a][3],1,0,'C',1);
					$pdf->Cell(1.5,.5,$ConcentradoViajes[$a][4],1,0,'C',1);
					$pdf->Cell(1.5,.5,$ConcentradoViajes[$a][5],1,0,'C',1);
					$pdf->Cell(1.5,.5,$ConcentradoViajes[$a][6],1,0,'C',1);
					$pdf->Cell(1.5,.5,$ConcentradoViajes[$a][7],1,0,'C',1);
					$pdf->Cell(1.5,.5,$ConcentradoViajes[$a][8],1,0,'C',1);
					$pdf->Cell(1.5,.5,$ConcentradoViajes[$a][9],1,0,'C',1);
					$pdf->Cell(1.5,.5,$ConcentradoViajes[$a][10],1,0,'C',1);
					$pdf->Cell(1.5,.5,$ConcentradoViajes[$a][11],1,0,'R',1);
					$pdf->Cell(1.5,.5,$ConcentradoViajes[$a][17],1,0,'R',1);
					$pdf->Cell(2,.5,$ConcentradoViajes[$a][16],1,1,'R',1);

					//Suma de los Viajes por semana de todos los camiones
						$TotalViajesConcentradoViajes=$TotalViajesConcentradoViajes+$ConcentradoViajes[$a][11];
					//Suma de los Volúmenes de los camiones por semana de todos los camiones
						$TotalVolumenConcentradoViajes=$TotalVolumenConcentradoViajes+$ConcentradoViajes[$a][12];
					//Suma de los Importes de los Viajes por semana de todos los camiones
						$TotalImporteConcentradoViajes=$TotalImporteConcentradoViajes+$ConcentradoViajes[$a][13];

				}
			}

			$TotalGlobalViajesConcentradoViajes=$TotalGlobalViajesConcentradoViajes+$TotalViajesConcentradoViajes;
			$TotalGlobalVolumenConcentradoViajes=$TotalGlobalVolumenConcentradoViajes+$TotalVolumenConcentradoViajes;
			$TotalGlobalImporteConcentradoViajes=$TotalGlobalImporteConcentradoViajes+$TotalImporteConcentradoViajes;

			//Establecemos Tamaño, Color y Tipo de Letra
			$pdf->SetFont('Times','B',8);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(204,204,204);

			//Formateamos las Cifras
			$TotalViajesConcentradoViajesF=number_format($TotalViajesConcentradoViajes,2,'.',',');
			$TotalVolumenConcentradoViajesF=number_format($TotalVolumenConcentradoViajes,2,'.',',');
			$TotalImporteConcentradoViajesF=number_format($TotalImporteConcentradoViajes,2,'.',',');

			$pdf->Cell(14.5,.5,'SUBTOTAL: ',1,0,'R',1);
			$pdf->Cell(1.5,.5,$TotalViajesConcentradoViajesF,1,0,'R',1);
			$pdf->Cell(1.5,.5,$TotalVolumenConcentradoViajesF,1,0,'R',1);
			$pdf->Cell(2,.5,$TotalImporteConcentradoViajesF,1,1,'R',1);

			$pdf->Cell(19.5,.4,' ',0,1,'L');
	}


	//Mostramos las Cifras Globales de la Semana

		//Establecemos Tamaño, Color y Tipo de Letra
		$pdf->SetFont('Times','B',8);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFillColor(0,0,0);

		//Formateamos los Saldos
		$TotalGlobalViajesConcentradoViajesF=number_format($TotalGlobalViajesConcentradoViajes,2,'.',',');
		$TotalGlobalVolumenConcentradoViajesF=number_format($TotalGlobalVolumenConcentradoViajes,2,'.',',');
		$TotalGlobalImporteConcentradoViajesF=number_format($TotalGlobalImporteConcentradoViajes,2,'.',',');

		$pdf->Cell(14.5,.5,'TOTAL GLOBAL: ',0,0,'R',1);
		$pdf->Cell(1.5,.5,$TotalGlobalViajesConcentradoViajesF,1,0,'R',1);
		$pdf->Cell(1.5,.5,$TotalGlobalVolumenConcentradoViajesF,1,0,'R',1);
		$pdf->Cell(2,.5,$TotalGlobalImporteConcentradoViajesF,1,1,'R',1);

		//Establecemos Tamaño, Color y Tipo de Letra
			$pdf->SetFont('Times','BI',8);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(255,255,255);

$pdf->Output();
?>