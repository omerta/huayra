<?php
	session_start();
	//file_put_contents('/tmp/sugau_saf.log', print_r($_POST, TRUE), FILE_APPEND);

	use Doctrine\ORM\Tools\Setup;
	use Doctrine\ORM\EntityManager;

	/*
	 * antigua función solo referencial
	 * require_once("sigesp_saf_c_materiales.php");
	 */

	/* doctrine */
	require_once "doctrine/bootstrap.php";
	$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
	$entityManager = EntityManager::create($dbParams, $config);

	/* entidad */
	require_once "entidades/SafTipoestructura.php";
	require_once "entidades/SigespEmpresa.php";

	$ls_codtipest = $_POST['codtipest'];
	$ls_dentipest = $_POST['dentipest'];
	$status = $_POST['status'];

	/* registro de sucesos */
	$la_seguridad["empresa"]= $_POST['log_empresa'];
	$la_seguridad["sistema"]= $_POST['log_sistema'];
	$la_seguridad["logusr"]= $_POST['log_logusr'];
	$la_seguridad["ventanas"]= $_POST['log_ventanas'];

	if ($status == "" || $status == "G")
  {
  	Guardar($ls_codtipest,$ls_dentipest,$status,$la_seguridad);
  }elseif ($status == "DELETE") {
  	Eliminar($ls_codtipest,$la_seguridad);
  }

	/*
	 * @TODO agregar caracteristica de multi-empresa (codemp,codtipest)
	 * @TODO agregar operaciones a la bitacora
	 */
	function Guardar($ls_codtipest,$ls_dentipest,$status,$la_seguridad)
	{
		global $entityManager;

		$ls_codemp = $_SESSION["la_empresa"]["codemp"];

		if($status=="")
		{
			/*
			 * función antigua solo referencial
			 * $ls_valido=$io_material->guardar($ls_codtipest, $ls_dentipest, $ls_existe, $la_seguridad);
			 */

			/* */
			try {
				//$product = new SafTipoestructura();
				//$product->setCodemp($ls_codemp);
				//$product->setCodtipest($ls_codtipest);
				//$product->setDentipest($ls_dentipest);

				$sigespEmpresa = $entityManager->find('SigespEmpresa', $ls_codemp);

				$tipoEstructura = new SafTipoestructura();
				$tipoEstructura->SetCodemp($sigespEmpresa);
				$tipoEstructura->SetDentipest($ls_dentipest);

				$entityManager->persist($tipoEstructura);
				$entityManager->flush();

				$codigo = $tipoEstructura->getCodtipest();
				$lb_valido[0] = true;
				$lb_valido[1] = $codigo;
			} catch (Exception $e) {
				$lb_valido[0] = false;
				$lb_valido[1] = $e->getMessage();
			}
		}elseif($status=="G")
		{
			/*
			 * $ls_valido=$io_material->uf_elimina_materiales($ls_codtipest, $la_seguridad);
			 */

			 /* */
			 //$material = $entityManager->getRepository('SafTipoEstructura')->findBy(array(
			 //	'codtipest' => $ls_codtipest,
			 //	'codemp' => $ls_codemp));
			 $material = $entityManager->find('SafTipoestructura', $ls_codtipest);
			 if ($material === null){
				 $lb_valido[0] = false;
			 }else{
				 //file_put_contents('/tmp/sugau_saf.log', print_r($material, TRUE), FILE_APPEND);
				 $material->setDentipest($ls_dentipest);
				 $entityManager->flush();
				 $lb_valido[0] = true;
			 }

		}

		//file_put_contents('/tmp/sugau_saf.log', print_r($lb_valido, TRUE), FILE_APPEND);
    echo json_encode($lb_valido);
	}

	function Eliminar($ls_catalogo,$la_seguridad)
	{
		global $entityManager;

		$material = $entityManager->find('SafTipoEstructura', $ls_catalogo);
		if(!$material){
			$lb_valido[0] = false;
		}else{
			$entityManager->remove($material);
			$entityManager->flush();
			$lb_valido[0] = true;
			/* para activar un warning */
			$lb_valido[1] = "";
		}

		echo json_encode($lb_valido);
	}

?>
