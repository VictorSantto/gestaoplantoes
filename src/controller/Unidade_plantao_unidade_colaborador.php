<?php

	/**
	 * Generated by Getz Framework
	 *
	 * @author Mario Sakamoto <mskamot@gmail.com>
	 * @see https://wtag.com.br/getz
	 */
	 
	use lib\getz;
	use src\logic;	 
	use src\model;	 
	
	require_once($_DOCUMENT_ROOT . "/lib/getz/Activator.php");
	
	/*
	 * Filters
	 */
	$where = "";
	
	if ($search != "")
		$where = "unidade_plantao_unidade_colaborador.hora_inicial LIKE \"%" . $search . "%\"";	
		
	if ($code != "")
		$where = "unidade_plantao_unidade_colaborador.id = " . $code;
	
	if (isset($_GET["friendly"]))
		$where = "unidade_plantao_unidade_colaborador.hora_inicial = \"" . removeLine($_GET["friendly"]) . "\"";	
		
	$limit = "";	
	
	if ($order != "") {
		$o = explode("<gz>", $order);
		if ($method == "stateReadAll" || $method == "stateCalledAll") {
			$limit = $o[0] . " " . $o[1];
		} else {
			$limit = $o[0] . " " . $o[1] . " LIMIT " . 
					(($position * $itensPerPage) - $itensPerPage) . ", " . $itensPerPage;
		}		
	} else {
		if ($method == "stateReadAll" || $method == "stateCalledAll") {
			$limit = "unidade_plantao_unidade_colaborador.ordem ASC";	
		} else {
			if ($position > 0 && $itensPerPage > 0) {
				$limit = "unidade_plantao_unidade_colaborador.id DESC LIMIT " . 
						(($position * $itensPerPage) - $itensPerPage) . ", " . $itensPerPage;	
			}
		}
	}
	
	/**************************************************
	 * Webpage
	 **************************************************/		
	
	/*
	 * Page
	 */
	if ($method == "page") {
		/*
		 * SEO
		 */
		$view->setTitle(ucfirst($screen));
		$view->setDescription("");
		$view->setKeywords("");
		
		$daoFactory->beginTransaction();
		$response["unidade_plantao_unidade_colaborador"] = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->read($where, $limit, true);
		$daoFactory->close();
		
		if (isset($_GET["friendly"]))
			$view->setTitle($response["unidade_plantao_unidade_colaborador"][0]["unidade_plantao_unidade_colaborador.hora_inicial"]);

		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/header.html", $response);
		
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . 
				(isset($_GET["friendly"]) ? "/html/unidade_plantao_unidade_colaborador.html" : "/html/unidade_plantao_unidade_colaborador.html"), $response);
		
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/footer.html", $response);
	}
	
	/**************************************************
	 * Webservice
	 **************************************************/	

	/*
	 * Create
	 */
	else if ($method == "api-create") {
		enableCORS();
		if (isset($_POST["request"])) {
			$request = json_decode($_POST["request"], true);
			// $request[0]["@_PARAM"] = $daoFactory->prepare($request[0]["@_PARAM"]); // Prepare with sql injection.

			$daoFactory->beginTransaction();
			$unidade_plantao_unidade_colaborador = new model\Unidade_plantao_unidade_colaborador();
			$unidade_plantao_unidade_colaborador->setHora_inicial(logicNull(controllerDateTime($request["unidade_plantao_unidade_colaborador.hora_inicial"])));
			$unidade_plantao_unidade_colaborador->setHora_final(logicNull(controllerDateTime($request["unidade_plantao_unidade_colaborador.hora_final"])));
			$unidade_plantao_unidade_colaborador->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_plantao_unidade_colaborador->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_plantao_unidade_colaborador->setUnidade_plantao($request["unidade_plantao_unidade_colaborador.unidade_plantao"]);
			$unidade_plantao_unidade_colaborador->setUnidade_colaborador($request["unidade_plantao_unidade_colaborador.unidade_colaborador"]);
			
			$resultDao = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->create($unidade_plantao_unidade_colaborador);

			if ($resultDao) {
				$daoFactory->commit();
				$response["message"] = "success";
			} else {							
				$daoFactory->rollback();
				$response["message"] = "error";
			}

			$daoFactory->close();
		} else {
			$response["message"] = "error";
		}
		
		echo $view->json($response);
	}
	
	/*
	 * Read
	 */
	else if ($method == "api-read") {
		enableCORS();
		
		if (isset($_POST["request"])) {
			$request = json_decode($_POST["request"], true);
			
			$limit = "unidade_plantao_unidade_colaborador.id DESC LIMIT " . 
					(($request[0]["page"] * $request[0]["pageSize"]) - 
					$request[0]["pageSize"]) . ", " . $request[0]["pageSize"];	
		}
		
		$daoFactory->beginTransaction();
		$unidade_plantao_unidade_colaborador = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->read("", $limit, false);
		$daoFactory->close();
		
		echo $view->json($unidade_plantao_unidade_colaborador);
	}
	
	/*
	 * Update
	 */
	else if ($method == "api-update") {	
		enableCORS();
		if (isset($_POST["request"])) {
			$request = json_decode($_POST["request"], true);
			// $request[0]["@_PARAM"] = $daoFactory->prepare($request[0]["@_PARAM"]); // Prepare with sql injection.
			
			$unidade_plantao_unidade_colaborador = new model\Unidade_plantao_unidade_colaborador();
			$unidade_plantao_unidade_colaborador->setId($request["unidade_plantao_unidade_colaborador.id"]);
			$unidade_plantao_unidade_colaborador->setHora_inicial(logicNull(controllerDateTime($request["unidade_plantao_unidade_colaborador.hora_inicial"])));
			$unidade_plantao_unidade_colaborador->setHora_final(logicNull(controllerDateTime($request["unidade_plantao_unidade_colaborador.hora_final"])));
			$unidade_plantao_unidade_colaborador->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_plantao_unidade_colaborador->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_plantao_unidade_colaborador->setUnidade_plantao($request["unidade_plantao_unidade_colaborador.unidade_plantao"]);
			$unidade_plantao_unidade_colaborador->setUnidade_colaborador($request["unidade_plantao_unidade_colaborador.unidade_colaborador"]);
			
			$daoFactory->beginTransaction();
			$resultDao = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->update($unidade_plantao_unidade_colaborador);

			if ($resultDao) {
				$daoFactory->commit();
				$response["message"] = "success";
			} else {							
				$daoFactory->rollback();
				$response["message"] = "error";
			}

			$daoFactory->close();
		} else {
			$response["message"] = "error";
		}
		
		echo $view->json($response);
	}
	
	/* 
	 * Delete
	 */
	else if ($method == "api-delete") {
		enableCORS();
		if (isset($_POST["request"])) {
			$request = json_decode($_POST["request"], true);
			$request["unidade_plantao_unidade_colaborador.id"] = $daoFactory->prepare($request["unidade_plantao_unidade_colaborador.id"]); // Prepare with sql injection.
				
			$result = true;
			$lines = explode("<gz>", $request["unidade_plantao_unidade_colaborador.id"]);

			$daoFactory->beginTransaction();

			for ($i = 0; $i < sizeof($lines); $i++) {
				$where = "unidade_plantao_unidade_colaborador.id = " . $lines[$i];
				
				$resultDao = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->delete($where);
				$result = !$result ? false : (!$resultDao ? false : true);
			}

			if ($result) {
				$daoFactory->commit();
				$response["message"] = "success";
			} else {							
				$daoFactory->rollback();
				$response["message"] = "error";
			}

			$daoFactory->close();
		} else {
			$response["message"] = "error";
		} 

		echo $view->json($response);
	}
	
	else if ($method == "changeOrder") {		
		$result = true;
		$daoFactory->beginTransaction();
		$call = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->read("unidade_plantao_unidade_colaborador.id = " . $form[0], "", false);
		$answer = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->read("unidade_plantao_unidade_colaborador.id = " . $form[1], "", false);
		$unidade_plantao_unidade_colaboradorDao = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->read("unidade_plantao_unidade_colaborador.ordem >= " . $answer[0]["unidade_plantao_unidade_colaborador.ordem"], "", false);
		if (is_array($unidade_plantao_unidade_colaboradorDao) && sizeof($unidade_plantao_unidade_colaboradorDao) > 0) {
			for ($x = 0; $x < sizeof($unidade_plantao_unidade_colaboradorDao); $x++) {
				$unidade_plantao_unidade_colaborador = new model\Unidade_plantao_unidade_colaborador();
				$unidade_plantao_unidade_colaborador->setId($unidade_plantao_unidade_colaboradorDao[$x]["unidade_plantao_unidade_colaborador.id"]);
				$unidade_plantao_unidade_colaborador->setHora_inicial(logicNull(controllerDateTime($unidade_plantao_unidade_colaboradorDao[$x]["unidade_plantao_unidade_colaborador.hora_inicial"])));
			$unidade_plantao_unidade_colaborador->setHora_final(logicNull(controllerDateTime($unidade_plantao_unidade_colaboradorDao[$x]["unidade_plantao_unidade_colaborador.hora_final"])));
			$unidade_plantao_unidade_colaborador->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_plantao_unidade_colaborador->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_plantao_unidade_colaborador->setUnidade_plantao($unidade_plantao_unidade_colaboradorDao[$x]["unidade_plantao_unidade_colaborador.unidade_plantao"]);
			$unidade_plantao_unidade_colaborador->setUnidade_colaborador($unidade_plantao_unidade_colaboradorDao[$x]["unidade_plantao_unidade_colaborador.unidade_colaborador"]);
			
				$resultDao = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->update($unidade_plantao_unidade_colaborador);			
				$result = !$result ? false : (!$resultDao ? false : true);
			}
			$unidade_plantao_unidade_colaborador = new model\Unidade_plantao_unidade_colaborador();
			$unidade_plantao_unidade_colaborador->setId($call[0]["unidade_plantao_unidade_colaborador.id"]);
			$unidade_plantao_unidade_colaborador->setHora_inicial(logicNull(controllerDateTime($call[0]["unidade_plantao_unidade_colaborador.hora_inicial"])));
			$unidade_plantao_unidade_colaborador->setHora_final(logicNull(controllerDateTime($call[0]["unidade_plantao_unidade_colaborador.hora_final"])));
			$unidade_plantao_unidade_colaborador->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_plantao_unidade_colaborador->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_plantao_unidade_colaborador->setUnidade_plantao($call[0]["unidade_plantao_unidade_colaborador.unidade_plantao"]);
			$unidade_plantao_unidade_colaborador->setUnidade_colaborador($call[0]["unidade_plantao_unidade_colaborador.unidade_colaborador"]);
			
			$resultDao = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->update($unidade_plantao_unidade_colaborador);			
			$result = !$result ? false : (!$resultDao ? false : true);
		}
		if ($result) {
			$daoFactory->commit();
			$response[0]["message"] = "success";
		} else {							
			$daoFactory->rollback();
			$response[0]["message"] = "error";
		}
		$daoFactory->close();
		echo $darth->json($response);
	}
	
	/**************************************************
	 * System
	 **************************************************/	
	
	else {
		if (!getActiveSession($_ROOT . $_MODULE)) 
			echo "<script>goTo(\"/login/1\");</script>";
		else {
			/*
			 * Create
			 */
			if ($method == "stateCreate") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method))
					echo "<script>goTo(\"/login/1\");</script>";	
				else {
					$daoFactory->beginTransaction();
					$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
					$response["unidade_plantoes"] = $daoFactory->getUnidade_plantoesDao()->read("", "unidade_plantoes.id ASC", false);
					$response["unidade_colaboradores"] = $daoFactory->getUnidade_colaboradoresDao()->read("", "unidade_colaboradores.id ASC", false);
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_plantao_unidade_colaborador/unidade_plantao_unidade_colaboradorCRT.html", $response);
				}
			}

			/*
			 * Read
			 */
			else if ($method == "stateRead" || $method == "stateReadAll") {
				if ($method == "stateReadAll") {
					$method = "stateRead";
				}
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method))
					echo "<script>goTo(\"/login/1\");</script>";	
				else {
					$daoFactory->beginTransaction();
					$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
					$response["unidade_plantao_unidade_colaborador"] = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->read($where, $limit, true);
					if (!is_array($response["unidade_plantao_unidade_colaborador"])) {
						$response["data_not_found"][0]["value"] = "<p>Não possui registro.</p>";
					}
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_plantao_unidade_colaborador/unidade_plantao_unidade_colaboradorRD.html", $response);
				}
			}

			/*
			 * Update
			 */
			else if ($method == "stateUpdate") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method))
					echo "<script>goTo(\"/login/1\");</script>";	
				else {
					$daoFactory->beginTransaction();
					$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
					$response["unidade_plantao_unidade_colaborador"] = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->read($where, "", true);
					$response["unidade_plantao_unidade_colaborador"][0]["unidade_plantao_unidade_colaborador.unidade_plantoes"] = $daoFactory->getUnidade_plantoesDao()->read("", "unidade_plantoes.id ASC", false);
					for ($x = 0; $x < sizeof($response["unidade_plantao_unidade_colaborador"][0]["unidade_plantao_unidade_colaborador.unidade_plantoes"]); $x++) {
						if ($response["unidade_plantao_unidade_colaborador"][0]["unidade_plantao_unidade_colaborador.unidade_plantoes"][$x]["unidade_plantoes.id"] == 
								$response["unidade_plantao_unidade_colaborador"][0]["unidade_plantao_unidade_colaborador.unidade_plantao"]) {
							$response["unidade_plantao_unidade_colaborador"][0]["unidade_plantao_unidade_colaborador.unidade_plantoes"][$x]["unidade_plantoes.selected"] = "selected";
						}
					}
					$response["unidade_plantao_unidade_colaborador"][0]["unidade_plantao_unidade_colaborador.unidade_colaboradores"] = $daoFactory->getUnidade_colaboradoresDao()->read("", "unidade_colaboradores.id ASC", false);
					for ($x = 0; $x < sizeof($response["unidade_plantao_unidade_colaborador"][0]["unidade_plantao_unidade_colaborador.unidade_colaboradores"]); $x++) {
						if ($response["unidade_plantao_unidade_colaborador"][0]["unidade_plantao_unidade_colaborador.unidade_colaboradores"][$x]["unidade_colaboradores.id"] == 
								$response["unidade_plantao_unidade_colaborador"][0]["unidade_plantao_unidade_colaborador.unidade_colaborador"]) {
							$response["unidade_plantao_unidade_colaborador"][0]["unidade_plantao_unidade_colaborador.unidade_colaboradores"][$x]["unidade_colaboradores.selected"] = "selected";
						}
					}
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_plantao_unidade_colaborador/unidade_plantao_unidade_colaboradorUPD.html", $response);
				}
			}

			/*
			 * Called
			 */
			else if ($method == "stateCalled" || $method == "stateCalledAll") {
				if ($method == "stateCalledAll") {
					$method = "stateCalled";
				}
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method))
					echo "<script>goTo(\"/login/1\");</script>";	
				else {
					/*
					 * Insert your foreign key here
					 */
					if ($where != "")
						$where .= " AND unidade_plantao_unidade_colaborador.@_FOREIGN_KEY = " . $base;
					else 
						$where = "unidade_plantao_unidade_colaborador.@_FOREIGN_KEY = " . $base;
						
					$daoFactory->beginTransaction();
					$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
					$response["unidade_plantao_unidade_colaborador"] = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->read($where, $limit, true);
					if (!is_array($response["unidade_plantao_unidade_colaborador"])) {
						$response["data_not_found"][0]["value"] = "<p>Não possui registro.</p>";
					}
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_plantao_unidade_colaborador/unidade_plantao_unidade_colaboradorCLL.html", $response);
				}
			}

			/*
			 * Screen
			 */
			else if ($method == "screen") {
				if ($base != "") {
					$arrBase = explode("<gz>", $base);
					
					if (sizeof($arrBase) > 1) {
						if ($where != "")
							$where .= " AND unidade_plantao_unidade_colaborador.@_FOREIGN_KEY = " . $arrBase[1];
						else
							$where = "unidade_plantao_unidade_colaborador.@_FOREIGN_KEY = " . $arrBase[1];
					}
				}
				
				$limit = "unidade_plantao_unidade_colaborador.id DESC LIMIT " . (($position * 5) - 5) . ", 5";

				$daoFactory->beginTransaction();
				$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
				$response["unidade_plantao_unidade_colaborador"] = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->read($where, $limit, true);
				$daoFactory->close();

				echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_plantao_unidade_colaborador/unidade_plantao_unidade_colaboradorSCR.html", $response) . 
						"<size>" . (is_array($response["unidade_plantao_unidade_colaborador"]) ? $response["unidade_plantao_unidade_colaborador"][0]["unidade_plantao_unidade_colaborador.size"] : 0) . "<theme>455a64";
			}

			/*
			 * Screen handler
			 */
			else if ($method == "screenHandler") {	
				$where = "";

				// Get value from combo
				$cmb = explode("<gz>", $search);

				if ($cmb[1] != "")
					$where = "unidade_plantao_unidade_colaborador.id = " . $cmb[1];

				$daoFactory->beginTransaction();
				$response["unidade_plantao_unidade_colaborador"] = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->comboScr($where);
				$daoFactory->close();

				echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_plantao_unidade_colaborador/unidade_plantao_unidade_colaboradorCMB.html", $response);
			}

			/*
			 * Create
			 */
			else if ($method == "create") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method)) {
					$response["message"] = "permission";
					
					echo $view->json($response);
				} else {
					$unidade_plantao_unidade_colaborador = new model\Unidade_plantao_unidade_colaborador();
					$unidade_plantao_unidade_colaborador->setHora_inicial(logicNull(controllerDateTime($form[0])));
					$unidade_plantao_unidade_colaborador->setHora_final(logicNull(controllerDateTime($form[1])));
					$unidade_plantao_unidade_colaborador->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_plantao_unidade_colaborador->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_plantao_unidade_colaborador->setUnidade_plantao($form[2]);
					$unidade_plantao_unidade_colaborador->setUnidade_colaborador($form[3]);
					
					$daoFactory->beginTransaction();
					$resultDao = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->create($unidade_plantao_unidade_colaborador);

					if ($resultDao) {
						$daoFactory->commit();
						$response["message"] = "success";				
					} else {							
						$daoFactory->rollback();
						$response["message"] = "error";
					}

					$daoFactory->close();

					echo $view->json($response);
				}
			}

			/*
			 * Action update
			 */
			else if ($method == "update") {	
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method)) {
					$response["message"] = "permission";
					
					echo $view->json($response);
				} else {
					$unidade_plantao_unidade_colaborador = new model\Unidade_plantao_unidade_colaborador();
					$unidade_plantao_unidade_colaborador->setId($code);
					$unidade_plantao_unidade_colaborador->setHora_inicial(logicNull(controllerDateTime($form[0])));
					$unidade_plantao_unidade_colaborador->setHora_final(logicNull(controllerDateTime($form[1])));
					$unidade_plantao_unidade_colaborador->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_plantao_unidade_colaborador->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_plantao_unidade_colaborador->setUnidade_plantao($form[2]);
					$unidade_plantao_unidade_colaborador->setUnidade_colaborador($form[3]);
					
					$daoFactory->beginTransaction();
					$resultDao = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->update($unidade_plantao_unidade_colaborador);

					if ($resultDao) {
						$daoFactory->commit();
						$response["message"] = "success";
					} else {							
						$daoFactory->rollback();
						$response["message"] = "error";
					}

					$daoFactory->close();

					echo $view->json($response);
				}
			}
			
			/* 
			 * Action delete
			 */
			else if ($method == "delete") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method)) {
					$response["message"] = "permission";
					
					echo $view->json($response);
				} else {
					$result = true;
					$lines = explode("<gz>", $code);

					$daoFactory->beginTransaction();

					for ($i = 1; $i < sizeof($lines); $i++) {
						$where = "unidade_plantao_unidade_colaborador.id = " . $lines[$i];
						
						$resultDao = $daoFactory->getUnidade_plantao_unidade_colaboradorDao()->delete($where);
						$result = !$result ? false : (!$resultDao ? false : true);
					}

					if ($result) {
						$daoFactory->commit();
						$response["message"] = "success";
					} else {							
						$daoFactory->rollback();
						$response["message"] = "error";
					}

					$daoFactory->close();

					echo $view->json($response);	
				}
			}
		}
	}

?>