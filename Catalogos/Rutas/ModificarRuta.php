<?php 
session_start();
require_once("../../inc/php/conexiones/SCA.php");
require_once("../../inc/php/dto/DTORuta.php");
require_once("../../inc/php/dao/DAORuta.php");
require_once("../../inc/php/dto/DTOArchivoRuta.php");
require_once("../../inc/php/dao/DAOArchivoRuta.php");
require_once("../../inc/generales.php");
$tac = SCA::getConexion();

	$dto = new DTORuta();
	$dao = new DAORuta();
	
	$existen=$_REQUEST["existen"];

	$dto->set_id_ruta($_REQUEST["idruta"]);
	$dto->set_id_proyecto($_SESSION["Proyecto"]);
	$dto->set_tipo_ruta($_REQUEST["tipo_ruta"]);
	$dto->set_id_origen($_REQUEST["origenes"]);
	$dto->set_id_tiro($_REQUEST["tiros"]);
	$dto->set_pkm($_REQUEST["pkm"]);
	$dto->set_kms($_REQUEST["kms"]);
	$dto->set_kma($_REQUEST["kma"]);
	$dto->set_total($_REQUEST["total"]);
	$dto->set_tminimo($_REQUEST["minimo"]);
	$dto->set_ttolerancia($_REQUEST["tolerancia"]);
	$dto->set_registra($_SESSION["IdUsuarioAc"]);
	

	$dto_ar = new DTOArchivoRuta();
	$dao_ar = new DAOArchivoRuta();
	
	$archivo = $_FILES["croquis"]["tmp_name"];
	$dto_ar->set_tipo($_FILES["croquis"]["type"]);
	$dto_ar->set_size($_FILES["croquis"]["size"]);


$mensajes="";
$errores = 0;
$del=0;



try
{
	$dto_ar->carga_archivo($archivo);
}
catch(Exception $e3)
{
	$mensajes.=regresa_mensaje("red",$e3->getMessage());
	$del=inc_delay($del);
}

if($existen==0)
{
try
	{
		$dao->actualiza($dto);
		$mensajes.=regresa_mensaje($dto->get_aux_kind(),$dto->get_aux_message());
		$del=inc_delay($del);
		$dto_ar->set_id_ruta($dto->get_id_ruta());
		
		
		try
		{	if($dto_ar->get_archivo()!="")
			{
				$dao_ar->registra($dto_ar);
				$mensajes.=regresa_mensaje($dto_ar->get_aux_kind(),$dto_ar->get_aux_message());
				$del=inc_delay($del);
			}
		}
		catch(Exception $e1)
		{
			$mensajes.=regresa_mensaje("red",$e1->getMessage());
			$del=inc_delay($del);
		}
	}
	catch(Exception $e)
	{
		$error++;
		$mensajes.=regresa_mensaje("red",$e->getMessage());
		$del=inc_delay($del);
	}
}
else
{

	try
		{

			if($dto_ar->get_archivo()!="")
			{
				$dao->deleteRutaArchivo($dto->get_id_ruta());
				$dto_ar->set_id_ruta($dto->get_id_ruta());
				$dao_ar->registra($dto_ar);
				$mensajes.=regresa_mensaje($dto_ar->get_aux_kind(),$dto_ar->get_aux_message());
				$del=inc_delay($del);
			}
		}
		catch(Exception $e1)
		{
			$mensajes.=regresa_mensaje("red",$e1->getMessage());
			$del=inc_delay($del);
		}
}
echo addslashes($mensajes);
?>
<script language="javascript" type="text/javascript">
presenta_mensaje('<?php echo addslashes($mensajes); ?>');
function presenta_mensaje(mensajes){
			window.parent.llena_mensaje(mensajes);
			window.parent.presenta_mensaje(<?php echo $del;?>);
		}
		function inicializa_formulario(){
			//window.parent.xajax_inicializa_formulario();
		}
		
</script>
<?php if($error==0){?><script language="javascript" type="text/javascript">inicializa_formulario();</script> <?php } ?>