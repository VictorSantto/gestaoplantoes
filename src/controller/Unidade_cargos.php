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
		$where = "unidade_cargos.unidade_cargo LIKE \"%" . $search . "%\"";	
		
	if ($code != "")
		$where = "unidade_cargos.id = " . $code;
	
	if (isset($_GET["friendly"]))
		$where = "unidade_cargos.unidade_cargo = \"" . removeLine($_GET["friendly"]) . "\"";	
		
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
			$limit = "unidade_cargos.ordem ASC";	
		} else {
			if ($position > 0 && $itensPerPage > 0) {
				$limit = "unidade_cargos.id DESC LIMIT " . 
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
		$response["unidade_cargos"] = $daoFactory->getUnidade_cargosDao()->read($where, $limit, true);
		$daoFactory->close();
		
		if (isset($_GET["friendly"]))
			$view->setTitle($response["unidade_cargos"][0]["unidade_cargos.unidade_cargo"]);

		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/header.html", $response);
		
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . 
				(isset($_GET["friendly"]) ? "/html/unidade_cargos.html" : "/html/unidade_cargos.html"), $response);
		
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
			$unidade_cargos = new model\Unidade_cargos();
			$unidade_cargos->setUnidade_cargo(logicNull($request["unidade_cargos.unidade_cargo"]));
			$unidade_cargos->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_cargos->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_cargos->setUnidade($request["unidade_cargos.unidade"]);
			
			$resultDao = $daoFactory->getUnidade_cargosDao()->create($unidade_cargos);

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
			
			$limit = "unidade_cargos.id DESC LIMIT " . 
					(($request[0]["page"] * $request[0]["pageSize"]) - 
					$request[0]["pageSize"]) . ", " . $request[0]["pageSize"];	
		}
		
		$daoFactory->beginTransaction();
		$unidade_cargos = $daoFactory->getUnidade_cargosDao()->read("", $limit, false);
		$daoFactory->close();
		
		echo $view->json($unidade_cargos);
	}
	
	/*
	 * Update
	 */
	else if ($method == "api-update") {	
		enableCORS();
		if (isset($_POST["request"])) {
			$request = json_decode($_POST["request"], true);
			// $request[0]["@_PARAM"] = $daoFactory->prepare($request[0]["@_PARAM"]); // Prepare with sql injection.
			
			$unidade_cargos = new model\Unidade_cargos();
			$unidade_cargos->setId($request["unidade_cargos.id"]);
			$unidade_cargos->setUnidade_cargo(logicNull($request["unidade_cargos.unidade_cargo"]));
			$unidade_cargos->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_cargos->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_cargos->setUnidade($request["unidade_cargos.unidade"]);
			
			$daoFactory->beginTransaction();
			$resultDao = $daoFactory->getUnidade_cargosDao()->update($unidade_cargos);

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
			$request["unidade_cargos.id"] = $daoFactory->prepare($request["unidade_cargos.id"]); // Prepare with sql injection.
				
			$result = true;
			$lines = explode("<gz>", $request["unidade_cargos.id"]);

			$daoFactory->beginTransaction();

			for ($i = 0; $i < sizeof($lines); $i++) {
				$where = "unidade_cargos.id = " . $lines[$i];
				
				$resultDao = $daoFactory->getUnidade_cargosDao()->delete($where);
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
		$call = $daoFactory->getUnidade_cargosDao()->read("unidade_cargos.id = " . $form[0], "", false);
		$answer = $daoFactory->getUnidade_cargosDao()->read("unidade_cargos.id = " . $form[1], "", false);
		$unidade_cargosDao = $daoFactory->getUnidade_cargosDao()->read("unidade_cargos.ordem >= " . $answer[0]["unidade_cargos.ordem"], "", false);
		if (is_array($unidade_cargosDao) && sizeof($unidade_cargosDao) > 0) {
			for ($x = 0; $x < sizeof($unidade_cargosDao); $x++) {
				$unidade_cargos = new model\Unidade_cargos();
				$unidade_cargos->setId($unidade_cargosDao[$x]["unidade_cargos.id"]);
				$unidade_cargos->setUnidade_cargo(logicNull($unidade_cargosDao[$x]["unidade_cargos.unidade_cargo"]));
			$unidade_cargos->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_cargos->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_cargos->setUnidade($unidade_cargosDao[$x]["unidade_cargos.unidade"]);
			
				$resultDao = $daoFactory->getUnidade_cargosDao()->update($unidade_cargos);			
				$result = !$result ? false : (!$resultDao ? false : true);
			}
			$unidade_cargos = new model\Unidade_cargos();
			$unidade_cargos->setId($call[0]["unidade_cargos.id"]);
			$unidade_cargos->setUnidade_cargo(logicNull($call[0]["unidade_cargos.unidade_cargo"]));
			$unidade_cargos->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_cargos->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_cargos->setUnidade($call[0]["unidade_cargos.unidade"]);
			
			$resultDao = $daoFactory->getUnidade_cargosDao()->update($unidade_cargos);			
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
					$response["unidades"] = $daoFactory->getUnidadesDao()->read("", "unidades.id ASC", false);
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_cargos/unidade_cargosCRT.html", $response);
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
					$response["unidade_cargos"] = $daoFactory->getUnidade_cargosDao()->read($where, $limit, true);
					if (!is_array($response["unidade_cargos"])) {
						$response["data_not_found"][0]["value"] = "<p>Não possui registro.</p>";
					}
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_cargos/unidade_cargosRD.html", $response);
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
					$response["unidade_cargos"] = $daoFactory->getUnidade_cargosDao()->read($where, "", true);
					$response["unidade_cargos"][0]["unidade_cargos.unidades"] = $daoFactory->getUnidadesDao()->read("", "unidades.id ASC", false);
					for ($x = 0; $x < sizeof($response["unidade_cargos"][0]["unidade_cargos.unidades"]); $x++) {
						if ($response["unidade_cargos"][0]["unidade_cargos.unidades"][$x]["unidades.id"] == 
								$response["unidade_cargos"][0]["unidade_cargos.unidade"]) {
							$response["unidade_cargos"][0]["unidade_cargos.unidades"][$x]["unidades.selected"] = "selected";
						}
					}
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_cargos/unidade_cargosUPD.html", $response);
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
						$where .= " AND unidade_cargos.@_FOREIGN_KEY = " . $base;
					else 
						$where = "unidade_cargos.@_FOREIGN_KEY = " . $base;
						
					$daoFactory->beginTransaction();
					$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
					$response["unidade_cargos"] = $daoFactory->getUnidade_cargosDao()->read($where, $limit, true);
					if (!is_array($response["unidade_cargos"])) {
						$response["data_not_found"][0]["value"] = "<p>Não possui registro.</p>";
					}
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_cargos/unidade_cargosCLL.html", $response);
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
							$where .= " AND unidade_cargos.@_FOREIGN_KEY = " . $arrBase[1];
						else
							$where = "unidade_cargos.@_FOREIGN_KEY = " . $arrBase[1];
					}
				}
				
				$limit = "unidade_cargos.id DESC LIMIT " . (($position * 5) - 5) . ", 5";

				$daoFactory->beginTransaction();
				$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
				$response["unidade_cargos"] = $daoFactory->getUnidade_cargosDao()->read($where, $limit, true);
				$daoFactory->close();

				echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_cargos/unidade_cargosSCR.html", $response) . 
						"<size>" . (is_array($response["unidade_cargos"]) ? $response["unidade_cargos"][0]["unidade_cargos.size"] : 0) . "<theme>455a64";
			}

			/*
			 * Screen handler
			 */
			else if ($method == "screenHandler") {	
				$where = "";

				// Get value from combo
				$cmb = explode("<gz>", $search);

				if ($cmb[1] != "")
					$where = "unidade_cargos.id = " . $cmb[1];

				$daoFactory->beginTransaction();
				$response["unidade_cargos"] = $daoFactory->getUnidade_cargosDao()->comboScr($where);
				$daoFactory->close();

				echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_cargos/unidade_cargosCMB.html", $response);
			}

			/*
			 * Create
			 */
			else if ($method == "create") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method)) {
					$response["message"] = "permission";
					
					echo $view->json($response);
				} else {
					$unidade_cargos = new model\Unidade_cargos();
					$unidade_cargos->setUnidade_cargo(logicNull($form[0]));
					$unidade_cargos->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_cargos->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_cargos->setUnidade($form[1]);
					
					$daoFactory->beginTransaction();
					$resultDao = $daoFactory->getUnidade_cargosDao()->create($unidade_cargos);

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
					$unidade_cargos = new model\Unidade_cargos();
					$unidade_cargos->setId($code);
					$unidade_cargos->setUnidade_cargo(logicNull($form[0]));
					$unidade_cargos->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_cargos->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_cargos->setUnidade($form[1]);
					
					$daoFactory->beginTransaction();
					$resultDao = $daoFactory->getUnidade_cargosDao()->update($unidade_cargos);

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
						$where = "unidade_cargos.id = " . $lines[$i];
						
						$resultDao = $daoFactory->getUnidade_cargosDao()->delete($where);
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