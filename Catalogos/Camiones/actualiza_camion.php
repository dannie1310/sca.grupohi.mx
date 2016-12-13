<?php 
session_start();
require_once("../../inc/php/conexiones/SCA.php");
require_once("../../inc/php/dto/DTOCamion.php");
require_once("../../inc/php/dao/DAOCamion.php");
require_once("../../inc/php/dto/DTOImagen.php");
require_once("../../inc/php/dao/DAOImagen.php");
require_once("../../inc/generales.php");
$tac = SCA::getConexion();

	$dto = new DTOCamion();
	$dao = new DAOCamion();
	


	$dto->set_id_camion($_REQUEST["idcamion"]);
	$dto->set_id_proyecto($_SESSION["Proyecto"]);
	$dto->set_sindicato($_REQUEST["sindicatos"]);
	$dto->set_empresa($_REQUEST["empresas"]);
	$dto->set_propietario($_REQUEST["propietario"]);
	$dto->set_operador($_REQUEST["operadores"]);
	$dto->set_economico($_REQUEST["eco"]);
	
	$dto->set_placas($_REQUEST["placas"]);
    $dto->set_placasCaja($_REQUEST["placas_caja"]);
	$dto->set_marca($_REQUEST["marcas"]);
	$dto->set_modelo($_REQUEST["modelo"]);
	$dto->set_aseguradora($_REQUEST["aseguradora"]);
	$dto->set_poliza($_REQUEST["poliza"]);
	$dto->set_vigencia($_REQUEST["vigencia"]);
	
	$dto->set_ancho($_REQUEST["ancho"]);
	$dto->set_largo($_REQUEST["largo"]);
	$dto->set_alto($_REQUEST["alto"]);
	$dto->set_gato($_REQUEST["gato"]);
	$dto->set_disminucion($_REQUEST["disminucion"]);

	$dto->set_extension($_REQUEST["extension"]);
	//$_REQUEST["real"] = str_replace(',','',$_REQUEST["real"]);
	$dto->set_cub_real(str_replace(',','',$_REQUEST["real"]));
	$dto->set_cub_pago(str_replace(',','',$_REQUEST["pago"]));
	$dto->set_dispositivo($_REQUEST["botones"]);
	$dto->set_estatus($_REQUEST["ctg_estatus"]);

	$dto_im_f = new DTOImagen();
	$dao_im_f = new DAOImagen();
	$dto_im_d = new DTOImagen();
	$dao_im_d = new DAOImagen();
	$dto_im_t = new DTOImagen();
	$dao_im_t = new DAOImagen();
	$dto_im_i = new DTOImagen();
	$dao_im_i = new DAOImagen();


$frente = $_FILES["frente"]["tmp_name"]; 
//echo 'f'.$frente;
$dto_im_f->set_tipo($_FILES["frente"]["type"]);
$dto_im_f->set_size($_FILES["frente"]["size"]);
$dto_im_f->set_tipo_c("f");

$derecha = $_FILES["derecha"]["tmp_name"]; 
$dto_im_d->set_tipo($_FILES["derecha"]["type"]);
$dto_im_d->set_size($_FILES["derecha"]["size"]);
$dto_im_d->set_tipo_c("d");

$atras = $_FILES["atras"]["tmp_name"]; 
$dto_im_t->set_tipo($_FILES["atras"]["type"]);
$dto_im_t->set_size($_FILES["atras"]["size"]);
$dto_im_t->set_tipo_c("t");

$izquierda = $_FILES["izquierda"]["tmp_name"]; 
$dto_im_i->set_tipo($_FILES["izquierda"]["type"]);
$dto_im_i->set_size($_FILES["izquierda"]["size"]);
$dto_im_i->set_tipo_c("i");


$mensajes="";
$errores = 0;
$error=0;
$del=0;
try
{
	$dto_im_f->carga_imagen($frente);
	$dto_im_d->carga_imagen($derecha);
	$dto_im_t->carga_imagen($atras);
	$dto_im_i->carga_imagen($izquierda);
}
catch(Exception $e3)
{
	$mensajes.=regresa_mensaje("red",$e3->getMessage());
	$del=inc_delay($del);
}

try
	{
		if(str_replace(',','',$_REQUEST["real"])<50 && str_replace(',','',$_REQUEST["pago"]<50))
		{	
			$dao->actualiza($dto);
			$dto_im_f->set_id_camion($dto->get_id_camion());
			$dto_im_d->set_id_camion($dto->get_id_camion());
			$dto_im_t->set_id_camion($dto->get_id_camion());
			$dto_im_i->set_id_camion($dto->get_id_camion());
			$mensajes.=regresa_mensaje($dto->get_aux_kind(),$dto->get_aux_message());
			$del=inc_delay($del);
			try
			{	if($dto_im_f->get_imagen()!="")
				{
					$dao_im_f->registra($dto_im_f);
					$mensajes.=regresa_mensaje($dto_im_f->get_aux_kind(),$dto_im_f->get_aux_message());
					$del=inc_delay($del);
				}
				if($dto_im_d->get_imagen()!="")
				{
					$dao_im_d->registra($dto_im_d);
					$mensajes.=regresa_mensaje($dto_im_d->get_aux_kind(),$dto_im_d->get_aux_message());
					$del=inc_delay($del);
				}
				if($dto_im_t->get_imagen()!="")
				{
					$dao_im_t->registra($dto_im_t);
					$mensajes.=regresa_mensaje($dto_im_t->get_aux_kind(),$dto_im_t->get_aux_message());
					$del=inc_delay($del);
				}
				if($dto_im_i->get_imagen()!="")
				{
					$dao_im_i->registra($dto_im_i);
					$mensajes.=regresa_mensaje($dto_im_i->get_aux_kind(),$dto_im_i->get_aux_message());
					$del=inc_delay($del);
				}
			}
			catch(Exception $e1)
			{
				$mensajes.=regresa_mensaje("red",$e1->getMessage());
				$del=inc_delay($del);
			}
		}
		else
		{
			throw new Exception("No existe una cubicaci&oacute;n mayor a 50m<sup>3</sup>");
		}
	}
	catch(Exception $e)
	{
		$error++;
		$mensajes.=regresa_mensaje("red",$e->getMessage());
		$del=inc_delay($del);
	}
echo addslashes($mensajes);
?>
<script language="javascript" type="text/javascript">
presenta_mensaje('<?php echo addslashes($mensajes); ?>');
function presenta_mensaje(mensajes){
			window.parent.llena_mensaje(mensajes);
			window.parent.presenta_mensaje(<?php echo $del;?>);
		}
		function inicializa_formulario(id_camion){
			window.parent.xajax_inicializa_formulario(id_camion);
			window.parent.actualiza_imagen();
			setTimeout("window.parent.location.reload()",<?php echo $del;?>)
			//kwindow.parent.location.reload();
		}
		
</script>
<?php if($error==0){?><script language="javascript" type="text/javascript">inicializa_formulario('<?php echo $_REQUEST["idcamion"]; ?>');</script> <?php } ?>