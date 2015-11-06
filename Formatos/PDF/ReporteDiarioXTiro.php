<?php
	session_start();

	require('../../Clases/PDF/fpdf.php');
	include("../../inc/php/conexiones/SCA.php");
	include("../../Clases/Funciones/FuncionesValidaViajes.php");

	//Incluimos los apartados para los pies de pagina y encabezados
	class PDF extends FPDF
	{
		//Cabecera de página
		function Header()
		{
		    //Logo
			    $this->Image('../../Imgs/LogosFormatos/LogoPeninsular.jpg',1,.8,2.5,2.5);
			    //Arial bold 15
			    $this->SetFont('Arial','B',10);
			    //Título
				$this->Cell(3.5,.5,' ',0,0,'L');
			    $this->Cell(23,.5,'CONTROL DIARIO DE ACARREOS POR FRENTE DE TRABAJO',0,1,'L');
				$this->Cell(3.5,.5,' ',0,0,'L');
				$this->Cell(23,.5,'LA PENINSULAR COMPAÑÍA CONSTRUCTORA, S.A. DE C.V.',0,1,'L');
				$this->Cell(3.5,.5,' ',0,0,'L');
				$this->Cell(23,.5,'OBRA: LIBRAMIENTO AEROPUERTO MORELIA',0,1,'L');
				$this->Cell(3.5,.5,' ',0,0,'L');
				$this->Cell(23,.5,'REPORTE DE MOVIMIENTOS DE TIERRA POR FRENTE DE TRABAJO',0,1,'L');
				$this->Cell(3.5,.5,' ',0,0,'L');
				//Arial bold 15
			    $this->SetFont('Arial','BI',7);
				$this->Cell(23,.5,'FECHA DE IMPRESIÓN '.date("d-m-Y")."/".date("H:i:s",time()),0,1,'R');
			    //Salto de línea
			    $this->Ln(1);
		}

		//Pie de página
		function Footer()
		{
		    //Posición: a 1,5 cm del final
		    $this->SetY(-2.3);
		    //Arial italic 8
		    $this->SetFont('Arial','BI',7);
		    //Número de página
		    $this->Cell(3.5,.3,' ',0,0,'C',1);
			$this->Cell(6.5,.3,'CHECADOR',1,0,'C',1);
		    $this->Cell(6.5,.3,'Vo. Bo..',1,0,'C',1);
		    $this->Cell(6.5,.3,'ECO DEL EQUIPO DE CARGA',1,1,'C',1);
			
		    $this->Cell(3.5,.3,' ',0,0,'C',1);
			$this->Cell(6.5,1.5,' ',1,0,'R');
		    $this->Cell(6.5,1.5,' ',1,0,'R');
		    $this->Cell(6.5,1.5,' ',1,1,'R');
			
		    $this->Cell(26.5,.4,'Página '.$this->PageNo().'/{nb}',0,1,'R');
		}
	}
	
	//Creación del objeto de la clase heredada
	$pdf=new PDF('L','cm','Letter');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	//Comenzamos el Diseño del Enccabezado
	
		//Datos del Frente del Trabajo
			$pdf->Cell(2,.4,'Touch:',1,0,'C');
			$pdf->Cell(3,.4,'',1,0,'C');
			$pdf->Cell(3,.4,'Frente de Trabajo:',1,0,'C');
			$pdf->Cell(5,.4,'',1,1,'C');
			$pdf->Cell(2,.4,'Touch:',1,0,'C');
			$pdf->Cell(3,.4,'',1,0,'C');
			$pdf->Cell(3,.4,'Frente de Trabajo:',1,0,'C');
			$pdf->Cell(5,.4,'',1,1,'C');
			$pdf->Cell(2,.4,'Touch:',1,0,'C');
			$pdf->Cell(3,.4,'',1,0,'C');
			$pdf->Cell(3,.4,'Frente de Trabajo:',1,0,'C');
			$pdf->Cell(5,.4,'',1,1,'C');
			$pdf->Cell(26.5,.4,' ',0,1,'C');
	
		//Establecemos Tamaño, Color y Tipo de Letra para el Encabezado
			$pdf->SetFont('Times','B',8);
			$pdf->SetTextColor(255,255,255);
			$pdf->SetFillColor(0,0,0);
		
		//Dibujamos el Encabezado del Reporte
			$pdf->Cell(.5,.4,'#',1,0,'C',1);
			$pdf->Cell(1.5,.4,'Económico',1,0,'C',1);
			
			for($a=1;$a<51;$a++)
			{ $pdf->Cell(.4,.4,$a,1,0,'C',1); }
			
		$pdf->Cell(1,.4,'Total',1,0,'C',1);	
		$pdf->Cell(3.5,.4,'Firma',1,1,'C',1);
	
	//Comienza la Integración del Cuerpo
	
		//Establecemos Tamaño, Color y Tipo de Letra para el Contenido
			$pdf->SetFont('Times','B',8);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(255,255,255);
		
		//Dibujamos el Contenido
			for($z=1;$z<26;$z++)
			{
				$pdf->Cell(.5,.4,$z,1,0,'C',1);
				$pdf->Cell(1.5,.4,'Económico',1,0,'C',1);
				
				for($a=1;$a<51;$a++)
				{ $pdf->Cell(.4,.4,' ',1,0,'C',1); }
				
				$pdf->Cell(1,.4,' ',1,0,'C',1);	
				$pdf->Cell(3.5,.4,' ',1,1,'C',1);
			}
			
			$pdf->Cell(22,.4,'Subtotal: ',0,0,'R');
			$pdf->Cell(1,.4,' ',0,0,'C');	
			$pdf->Cell(3.5,.4,' ',0,1,'C');
			
		
		//Ponemos la Parte de las Observaciones
			$pdf->Cell(26.5,.4,' ',0,1,'C');
			$pdf->Cell(2.5,.4,'Observaciones:',0,0,'L',1);
			$pdf->Line(3,17.6,27.5,17.6);
			$pdf->Line(3,18.1,27.5,18.1);
			$pdf->Line(3,18.6,27.5,18.6);
	
	//Mandamos el Contenido a Pantalla
	$pdf->Output();


?>