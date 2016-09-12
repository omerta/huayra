<?php
	// saf/sigesp_saf_puente_materiales.php
	session_start();
	//file_put_contents('/tmp/sugau_saf.log', print_r($_SESSION, TRUE), FILE_APPEND);

	use Doctrine\ORM\Tools\Setup;
	use Doctrine\ORM\EntityManager;

	/* doctrine */
	require_once "doctrine/bootstrap.php";
	$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
	$entityManager = EntityManager::create($dbParams, $config);

	/* entidad */
	require_once "entidades/SafTipoestructura.php";
	require_once "entidades/SigespEmpresa.php";
	require_once "entidades/SssRegistroEventos.php";

	$ls_codtipest = $_POST['codtipest'];
	$ls_dentipest = $_POST['dentipest'];
	$status = $_POST['status'];

	/* registro de sucesos */
	$la_seguridad["empresa"]= $_POST['log_empresa'];
	$la_seguridad["sistema"]= $_POST['log_sistema'];
	$la_seguridad["logusr"]= $_POST['log_logusr'];
	$la_seguridad["ventanas"]= $_POST['log_ventanas'];
	$ls_codemp = $_SESSION["la_empresa"]["codemp"];
	require_once("../shared/class_folder/sigesp_c_seguridad.php");
	$ip = new sigesp_c_seguridad();
	$ip = $ip->getip();


	if ($status == "" || $status == "G")
  {
  	Guardar($ls_codtipest,$ls_dentipest,$status,$la_seguridad);
  }elseif ($status == "DELETE") {
  	Eliminar($ls_codtipest,$la_seguridad);
  }

	/*
	 * @TODO mejorar la inteligencia de los registros en bitacora
	 * 	guardando el registro y su bitácora.
	 */
	function Guardar($ls_codtipest,$ls_dentipest,$status,$la_seguridad)
	{
		global $entityManager, $ls_codemp, $ip;

		if($status=="")
		{
			/* */
			try {
				$sigespEmpresa = $entityManager->find('SigespEmpresa', $ls_codemp);

				$tipoEstructura = new SafTipoestructura();
				$tipoEstructura->SetCodemp($sigespEmpresa);
				$tipoEstructura->SetDentipest($ls_dentipest);

				$entityManager->persist($tipoEstructura);
				$entityManager->flush();

				$codigo = $tipoEstructura->getCodtipest();

				$lb_valido[0] = true;
				$lb_valido[1] = $codigo;

				$ls_evento = "INSERT";
				$ls_descripcion ="Se insertó el material ".$codigo;
				$ls_sisope = "N/D";

				registrar_evento($ls_codemp,$la_seguridad["logusr"],$la_seguridad["sistema"],
													$ls_evento,$la_seguridad["ventanas"],$ld_fecha,$ip,$ls_descripcion,$ls_sisope);

			} catch (Exception $e) {
				$lb_valido[0] = false;
				$lb_valido[1] = $e->getMessage();
			}
		}elseif($status=="G")
		{
			 $material = $entityManager->find('SafTipoestructura', $ls_codtipest);

			 if ($material === null)
			 {
				 $lb_valido[0] = false;
			 }else{
				 $material->setDentipest($ls_dentipest);
				 $entityManager->flush();
				 $lb_valido[0] = true;

				 $ls_evento = "UPDATE";
				 $ls_descripcion ="Se actualizó el material ".$ls_codtipest;
				 $ls_sisope="N/D";

				 registrar_evento($ls_codemp,$la_seguridad["logusr"],$la_seguridad["sistema"],
 													$ls_evento,$la_seguridad["ventanas"],$ld_fecha,$ip,$ls_descripcion,$ls_sisope);
			 }

		}
    echo json_encode($lb_valido);
	}

	function Eliminar($ls_codtipest,$la_seguridad)
	{
		global $entityManager, $ls_codemp, $ip;

		$material = $entityManager->find('SafTipoestructura', $ls_codtipest);
		if(!$material){
			$lb_valido[0] = false;
		}else{
			$entityManager->remove($material);
			$entityManager->flush();

			$ls_evento = "DELETE";
			$ls_descripcion ="Se eliminó el Material ".$ls_codtipest;
			$ls_sisope="N/D";

			registrar_evento($ls_codemp,$la_seguridad["logusr"],$la_seguridad["sistema"],
												$ls_evento,$la_seguridad["ventanas"],$ld_fecha,$ip,$ls_descripcion,$ls_sisope);

			$lb_valido[0] = true;
			/* para activar un warning */
			$lb_valido[1] = "";
		}

		echo json_encode($lb_valido);
	}

	function registrar_evento($codemp,$codusu,$codsis,$ls_evento,$nomven,$fecevetra,$equevetra,$desevetra,$ususisoper)
	{
		global $entityManager;
		$evento = new SssRegistroEventos();

		$ls_codintper="---------------------------------";

		$evento->setCodemp($codemp);
		$evento->setCodusu($codusu);
		$evento->setCodsis($codsis);
		$evento->setEvento($ls_evento);
		$evento->setNomven($nomven);
		$evento->setCodintper($ls_codintper);
		$evento->setFecevetra(new \DateTime);
		$evento->setEquevetra($equevetra);
		$evento->setDesevetra($desevetra);
		$evento->setUsusisoper($ususisoper);

		$entityManager->persist($evento);
		$entityManager->flush();
	}
?>
