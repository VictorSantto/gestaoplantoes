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
		$where = "unidade_colaboradores.unidade_colaborador LIKE \"%" . $search . "%\"";	
		
	if ($code != "")
		$where = "unidade_colaboradores.id = " . $code;
	
	if (isset($_GET["friendly"]))
		$where = "unidade_colaboradores.unidade_colaborador = \"" . removeLine($_GET["friendly"]) . "\"";	
		
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
			$limit = "unidade_colaboradores.ordem ASC";	
		} else {
			if ($position > 0 && $itensPerPage > 0) {
				$limit = "unidade_colaboradores.id DESC LIMIT " . 
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
		$response["unidade_colaboradores"] = $daoFactory->getUnidade_colaboradoresDao()->read($where, $limit, true);
		$daoFactory->close();
		
		if (isset($_GET["friendly"]))
			$view->setTitle($response["unidade_colaboradores"][0]["unidade_colaboradores.unidade_colaborador"]);

		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/header.html", $response);
		
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . 
				(isset($_GET["friendly"]) ? "/html/unidade_colaboradores.html" : "/html/unidade_colaboradores.html"), $response);
		
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
			$unidade_colaboradores = new model\Unidade_colaboradores();
			$unidade_colaboradores->setUnidade_colaborador(logicNull($request["unidade_colaboradores.unidade_colaborador"]));
			$unidade_colaboradores->setCpf(logicNull($request["unidade_colaboradores.cpf"]));
			$unidade_colaboradores->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_colaboradores->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_colaboradores->setUnidade($request["unidade_colaboradores.unidade"]);
			$unidade_colaboradores->setUnidade_cargo($request["unidade_colaboradores.unidade_cargo"]);
			
			$resultDao = $daoFactory->getUnidade_colaboradoresDao()->create($unidade_colaboradores);

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
			
			$limit = "unidade_colaboradores.id DESC LIMIT " . 
					(($request[0]["page"] * $request[0]["pageSize"]) - 
					$request[0]["pageSize"]) . ", " . $request[0]["pageSize"];	
		}
		
		$daoFactory->beginTransaction();
		$unidade_colaboradores = $daoFactory->getUnidade_colaboradoresDao()->read("", $limit, false);
		$daoFactory->close();
		
		echo $view->json($unidade_colaboradores);
	}
	
	/*
	 * Update
	 */
	else if ($method == "api-update") {	
		enableCORS();
		if (isset($_POST["request"])) {
			$request = json_decode($_POST["request"], true);
			// $request[0]["@_PARAM"] = $daoFactory->prepare($request[0]["@_PARAM"]); // Prepare with sql injection.
			
			$unidade_colaboradores = new model\Unidade_colaboradores();
			$unidade_colaboradores->setId($request["unidade_colaboradores.id"]);
			$unidade_colaboradores->setUnidade_colaborador(logicNull($request["unidade_colaboradores.unidade_colaborador"]));
			$unidade_colaboradores->setCpf(logicNull($request["unidade_colaboradores.cpf"]));
			$unidade_colaboradores->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_colaboradores->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_colaboradores->setUnidade($request["unidade_colaboradores.unidade"]);
			$unidade_colaboradores->setUnidade_cargo($request["unidade_colaboradores.unidade_cargo"]);
			
			$daoFactory->beginTransaction();
			$resultDao = $daoFactory->getUnidade_colaboradoresDao()->update($unidade_colaboradores);

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
			$request["unidade_colaboradores.id"] = $daoFactory->prepare($request["unidade_colaboradores.id"]); // Prepare with sql injection.
				
			$result = true;
			$lines = explode("<gz>", $request["unidade_colaboradores.id"]);

			$daoFactory->beginTransaction();

			for ($i = 0; $i < sizeof($lines); $i++) {
				$where = "unidade_colaboradores.id = " . $lines[$i];
				
				$resultDao = $daoFactory->getUnidade_colaboradoresDao()->delete($where);
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
		$call = $daoFactory->getUnidade_colaboradoresDao()->read("unidade_colaboradores.id = " . $form[0], "", false);
		$answer = $daoFactory->getUnidade_colaboradoresDao()->read("unidade_colaboradores.id = " . $form[1], "", false);
		$unidade_colaboradoresDao = $daoFactory->getUnidade_colaboradoresDao()->read("unidade_colaboradores.ordem >= " . $answer[0]["unidade_colaboradores.ordem"], "", false);
		if (is_array($unidade_colaboradoresDao) && sizeof($unidade_colaboradoresDao) > 0) {
			for ($x = 0; $x < sizeof($unidade_colaboradoresDao); $x++) {
				$unidade_colaboradores = new model\Unidade_colaboradores();
				$unidade_colaboradores->setId($unidade_colaboradoresDao[$x]["unidade_colaboradores.id"]);
				$unidade_colaboradores->setUnidade_colaborador(logicNull($unidade_colaboradoresDao[$x]["unidade_colaboradores.unidade_colaborador"]));
			$unidade_colaboradores->setCpf(logicNull($unidade_colaboradoresDao[$x]["unidade_colaboradores.cpf"]));
			$unidade_colaboradores->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_colaboradores->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_colaboradores->setUnidade($unidade_colaboradoresDao[$x]["unidade_colaboradores.unidade"]);
			$unidade_colaboradores->setUnidade_cargo($unidade_colaboradoresDao[$x]["unidade_colaboradores.unidade_cargo"]);
			
				$resultDao = $daoFactory->getUnidade_colaboradoresDao()->update($unidade_colaboradores);			
				$result = !$result ? false : (!$resultDao ? false : true);
			}
			$unidade_colaboradores = new model\Unidade_colaboradores();
			$unidade_colaboradores->setId($call[0]["unidade_colaboradores.id"]);
			$unidade_colaboradores->setUnidade_colaborador(logicNull($call[0]["unidade_colaboradores.unidade_colaborador"]));
			$unidade_colaboradores->setCpf(logicNull($call[0]["unidade_colaboradores.cpf"]));
			$unidade_colaboradores->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_colaboradores->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_colaboradores->setUnidade($call[0]["unidade_colaboradores.unidade"]);
			$unidade_colaboradores->setUnidade_cargo($call[0]["unidade_colaboradores.unidade_cargo"]);
			
			$resultDao = $daoFactory->getUnidade_colaboradoresDao()->update($unidade_colaboradores);			
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
					$response["unidade_cargos"] = $daoFactory->getUnidade_cargosDao()->read("", "unidade_cargos.id ASC", false);
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_colaboradores/unidade_colaboradoresCRT.html", $response);
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
					$response["unidade_colaboradores"] = $daoFactory->getUnidade_colaboradoresDao()->read($where, $limit, true);
					if (!is_array($response["unidade_colaboradores"])) {
						$response["data_not_found"][0]["value"] = "<p>Não possui registro.</p>";
					}
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_colaboradores/unidade_colaboradoresRD.html", $response);
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
					$response["unidade_colaboradores"] = $daoFactory->getUnidade_colaboradoresDao()->read($where, "", true);
					$response["unidade_colaboradores"][0]["unidade_colaboradores.unidades"] = $daoFactory->getUnidadesDao()->read("", "unidades.id ASC", false);
					for ($x = 0; $x < sizeof($response["unidade_colaboradores"][0]["unidade_colaboradores.unidades"]); $x++) {
						if ($response["unidade_colaboradores"][0]["unidade_colaboradores.unidades"][$x]["unidades.id"] == 
								$response["unidade_colaboradores"][0]["unidade_colaboradores.unidade"]) {
							$response["unidade_colaboradores"][0]["unidade_colaboradores.unidades"][$x]["unidades.selected"] = "selected";
						}
					}
					$response["unidade_colaboradores"][0]["unidade_colaboradores.unidade_cargos"] = $daoFactory->getUnidade_cargosDao()->read("", "unidade_cargos.id ASC", false);
					for ($x = 0; $x < sizeof($response["unidade_colaboradores"][0]["unidade_colaboradores.unidade_cargos"]); $x++) {
						if ($response["unidade_colaboradores"][0]["unidade_colaboradores.unidade_cargos"][$x]["unidade_cargos.id"] == 
								$response["unidade_colaboradores"][0]["unidade_colaboradores.unidade_cargo"]) {
							$response["unidade_colaboradores"][0]["unidade_colaboradores.unidade_cargos"][$x]["unidade_cargos.selected"] = "selected";
						}
					}
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_colaboradores/unidade_colaboradoresUPD.html", $response);
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
						$where .= " AND unidade_colaboradores.@_FOREIGN_KEY = " . $base;
					else 
						$where = "unidade_colaboradores.@_FOREIGN_KEY = " . $base;
						
					$daoFactory->beginTransaction();
					$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
					$response["unidade_colaboradores"] = $daoFactory->getUnidade_colaboradoresDao()->read($where, $limit, true);
					if (!is_array($response["unidade_colaboradores"])) {
						$response["data_not_found"][0]["value"] = "<p>Não possui registro.</p>";
					}
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_colaboradores/unidade_colaboradoresCLL.html", $response);
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
							$where .= " AND unidade_colaboradores.@_FOREIGN_KEY = " . $arrBase[1];
						else
							$where = "unidade_colaboradores.@_FOREIGN_KEY = " . $arrBase[1];
					}
				}
				
				$limit = "unidade_colaboradores.id DESC LIMIT " . (($position * 5) - 5) . ", 5";

				$daoFactory->beginTransaction();
				$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
				$response["unidade_colaboradores"] = $daoFactory->getUnidade_colaboradoresDao()->read($where, $limit, true);
				$daoFactory->close();

				echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_colaboradores/unidade_colaboradoresSCR.html", $response) . 
						"<size>" . (is_array($response["unidade_colaboradores"]) ? $response["unidade_colaboradores"][0]["unidade_colaboradores.size"] : 0) . "<theme>455a64";
			}

			/*
			 * Screen handler
			 */
			else if ($method == "screenHandler") {	
				$where = "";

				// Get value from combo
				$cmb = explode("<gz>", $search);

				if ($cmb[1] != "")
					$where = "unidade_colaboradores.id = " . $cmb[1];

				$daoFactory->beginTransaction();
				$response["unidade_colaboradores"] = $daoFactory->getUnidade_colaboradoresDao()->comboScr($where);
				$daoFactory->close();

				echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_colaboradores/unidade_colaboradoresCMB.html", $response);
			}

			/*
			 * Create
			 */
			else if ($method == "create") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method)) {
					$response["message"] = "permission";
					
					echo $view->json($response);
				} else {
					$unidade_colaboradores = new model\Unidade_colaboradores();
					$unidade_colaboradores->setUnidade_colaborador(logicNull($form[0]));
					$unidade_colaboradores->setCpf(logicNull($form[1]));
					$unidade_colaboradores->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_colaboradores->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_colaboradores->setUnidade($form[2]);
					$unidade_colaboradores->setUnidade_cargo($form[3]);
					
					$daoFactory->beginTransaction();
					$resultDao = $daoFactory->getUnidade_colaboradoresDao()->create($unidade_colaboradores);

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
					$unidade_colaboradores = new model\Unidade_colaboradores();
					$unidade_colaboradores->setId($code);
					$unidade_colaboradores->setUnidade_colaborador(logicNull($form[0]));
					$unidade_colaboradores->setCpf(logicNull($form[1]));
					$unidade_colaboradores->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_colaboradores->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_colaboradores->setUnidade($form[2]);
					$unidade_colaboradores->setUnidade_cargo($form[3]);
					
					$daoFactory->beginTransaction();
					$resultDao = $daoFactory->getUnidade_colaboradoresDao()->update($unidade_colaboradores);

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
						$where = "unidade_colaboradores.id = " . $lines[$i];
						
						$resultDao = $daoFactory->getUnidade_colaboradoresDao()->delete($where);
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