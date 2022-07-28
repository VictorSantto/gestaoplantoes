<?php

	/**
	 * Generated by Getz Framework
	 *
	 * @author Mario Sakamoto <mskamot@gmail.com>
	 * @see https://wtag.com.br/getz
	 * /
	 
	use lib\getz;
	use src\logic;	 
	use src\model;	 
	
	require_once($_DOCUMENT_ROOT . "/lib/getz/Activator.php");
	
	/*
	 * Filters
	 * /
	$where = "";
	
	if ($search != "")
		$where = "unidade_especializacoes.especializacao LIKE \"%" . $search . "%\"";	
		
	if ($code != "")
		$where = "unidade_especializacoes.id = " . $code;
	
	if (isset($_GET["friendly"]))
		$where = "unidade_especializacoes.especializacao = \"" . removeLine($_GET["friendly"]) . "\"";	
		
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
			$limit = "unidade_especializacoes.ordem ASC";	
		} else {
			if ($position > 0 && $itensPerPage > 0) {
				$limit = "unidade_especializacoes.id DESC LIMIT " . 
						(($position * $itensPerPage) - $itensPerPage) . ", " . $itensPerPage;	
			}
		}
	}
	
	/**************************************************
	 * Webpage
	 ************************************************** /		
	
	/*
	 * Page
	 * /
	if ($method == "page") {
		/*
		 * SEO
		 * /
		$view->setTitle(ucfirst($screen));
		$view->setDescription("");
		$view->setKeywords("");
		
		$daoFactory->beginTransaction();
		$response["unidade_especializacoes"] = $daoFactory->getUnidade_especializacoesDao()->read($where, $limit, true);
		$daoFactory->close();
		
		if (isset($_GET["friendly"]))
			$view->setTitle($response["unidade_especializacoes"][0]["unidade_especializacoes.especializacao"]);

		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/header.html", $response);
		
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . 
				(isset($_GET["friendly"]) ? "/html/unidade_especializacoes.html" : "/html/unidade_especializacoes.html"), $response);
		
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/footer.html", $response);
	}
	
	/**************************************************
	 * Webservice
	 ************************************************** /	

	/*
	 * Create
	 * /
	else if ($method == "api-create") {
		enableCORS();
		if (isset($_POST["request"])) {
			$request = json_decode($_POST["request"], true);
			// $request[0]["@_PARAM"] = $daoFactory->prepare($request[0]["@_PARAM"]); // Prepare with sql injection.

			$daoFactory->beginTransaction();
			$unidade_especializacoes = new model\Unidade_especializacoes();
			$unidade_especializacoes->setEspecializacao(logicNull($request["unidade_especializacoes.especializacao"]));
			$unidade_especializacoes->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_especializacoes->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_especializacoes->setUnidade($request["unidade_especializacoes.unidade"]);
			
			$resultDao = $daoFactory->getUnidade_especializacoesDao()->create($unidade_especializacoes);

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
	 * /
	else if ($method == "api-read") {
		enableCORS();
		
		if (isset($_POST["request"])) {
			$request = json_decode($_POST["request"], true);
			
			$limit = "unidade_especializacoes.id DESC LIMIT " . 
					(($request[0]["page"] * $request[0]["pageSize"]) - 
					$request[0]["pageSize"]) . ", " . $request[0]["pageSize"];	
		}
		
		$daoFactory->beginTransaction();
		$unidade_especializacoes = $daoFactory->getUnidade_especializacoesDao()->read("", $limit, false);
		$daoFactory->close();
		
		echo $view->json($unidade_especializacoes);
	}
	
	/*
	 * Update
	 * /
	else if ($method == "api-update") {	
		enableCORS();
		if (isset($_POST["request"])) {
			$request = json_decode($_POST["request"], true);
			// $request[0]["@_PARAM"] = $daoFactory->prepare($request[0]["@_PARAM"]); // Prepare with sql injection.
			
			$unidade_especializacoes = new model\Unidade_especializacoes();
			$unidade_especializacoes->setId($request["unidade_especializacoes.id"]);
			$unidade_especializacoes->setEspecializacao(logicNull($request["unidade_especializacoes.especializacao"]));
			$unidade_especializacoes->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_especializacoes->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_especializacoes->setUnidade($request["unidade_especializacoes.unidade"]);
			
			$daoFactory->beginTransaction();
			$resultDao = $daoFactory->getUnidade_especializacoesDao()->update($unidade_especializacoes);

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
	 * /
	else if ($method == "api-delete") {
		enableCORS();
		if (isset($_POST["request"])) {
			$request = json_decode($_POST["request"], true);
			$request["unidade_especializacoes.id"] = $daoFactory->prepare($request["unidade_especializacoes.id"]); // Prepare with sql injection.
				
			$result = true;
			$lines = explode("<gz>", $request["unidade_especializacoes.id"]);

			$daoFactory->beginTransaction();

			for ($i = 0; $i < sizeof($lines); $i++) {
				$where = "unidade_especializacoes.id = " . $lines[$i];
				
				$resultDao = $daoFactory->getUnidade_especializacoesDao()->delete($where);
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
		$call = $daoFactory->getUnidade_especializacoesDao()->read("unidade_especializacoes.id = " . $form[0], "", false);
		$answer = $daoFactory->getUnidade_especializacoesDao()->read("unidade_especializacoes.id = " . $form[1], "", false);
		$unidade_especializacoesDao = $daoFactory->getUnidade_especializacoesDao()->read("unidade_especializacoes.ordem >= " . $answer[0]["unidade_especializacoes.ordem"], "", false);
		if (is_array($unidade_especializacoesDao) && sizeof($unidade_especializacoesDao) > 0) {
			for ($x = 0; $x < sizeof($unidade_especializacoesDao); $x++) {
				$unidade_especializacoes = new model\Unidade_especializacoes();
				$unidade_especializacoes->setId($unidade_especializacoesDao[$x]["unidade_especializacoes.id"]);
				$unidade_especializacoes->setEspecializacao(logicNull($unidade_especializacoesDao[$x]["unidade_especializacoes.especializacao"]));
			$unidade_especializacoes->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_especializacoes->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_especializacoes->setUnidade($unidade_especializacoesDao[$x]["unidade_especializacoes.unidade"]);
			
				$resultDao = $daoFactory->getUnidade_especializacoesDao()->update($unidade_especializacoes);			
				$result = !$result ? false : (!$resultDao ? false : true);
			}
			$unidade_especializacoes = new model\Unidade_especializacoes();
			$unidade_especializacoes->setId($call[0]["unidade_especializacoes.id"]);
			$unidade_especializacoes->setEspecializacao(logicNull($call[0]["unidade_especializacoes.especializacao"]));
			$unidade_especializacoes->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_especializacoes->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
			$unidade_especializacoes->setUnidade($call[0]["unidade_especializacoes.unidade"]);
			
			$resultDao = $daoFactory->getUnidade_especializacoesDao()->update($unidade_especializacoes);			
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
	 ************************************************** /	
	
	else {
		if (!getActiveSession($_ROOT . $_MODULE)) 
			echo "<script>goTo(\"/login/1\");</script>";
		else {
			/*
			 * Create
			 * /
			if ($method == "stateCreate") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method))
					echo "<script>goTo(\"/login/1\");</script>";	
				else {
					$daoFactory->beginTransaction();
					$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
					$response["unidades"] = $daoFactory->getUnidadesDao()->read("", "unidades.id ASC", false);
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_especializacoes/unidade_especializacoesCRT.html", $response);
				}
			}

			/*
			 * Read
			 * /
			else if ($method == "stateRead" || $method == "stateReadAll") {
				if ($method == "stateReadAll") {
					$method = "stateRead";
				}
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method))
					echo "<script>goTo(\"/login/1\");</script>";	
				else {
					$daoFactory->beginTransaction();
					$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
					$response["unidade_especializacoes"] = $daoFactory->getUnidade_especializacoesDao()->read($where, $limit, true);
					if (!is_array($response["unidade_especializacoes"])) {
						$response["data_not_found"][0]["value"] = "<p>Não possui registro.</p>";
					}
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_especializacoes/unidade_especializacoesRD.html", $response);
				}
			}

			/*
			 * Update
			 * /
			else if ($method == "stateUpdate") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method))
					echo "<script>goTo(\"/login/1\");</script>";	
				else {
					$daoFactory->beginTransaction();
					$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
					$response["unidade_especializacoes"] = $daoFactory->getUnidade_especializacoesDao()->read($where, "", true);
					$response["unidade_especializacoes"][0]["unidade_especializacoes.unidades"] = $daoFactory->getUnidadesDao()->read("", "unidades.id ASC", false);
					for ($x = 0; $x < sizeof($response["unidade_especializacoes"][0]["unidade_especializacoes.unidades"]); $x++) {
						if ($response["unidade_especializacoes"][0]["unidade_especializacoes.unidades"][$x]["unidades.id"] == 
								$response["unidade_especializacoes"][0]["unidade_especializacoes.unidade"]) {
							$response["unidade_especializacoes"][0]["unidade_especializacoes.unidades"][$x]["unidades.selected"] = "selected";
						}
					}
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_especializacoes/unidade_especializacoesUPD.html", $response);
				}
			}

			/*
			 * Called
			 * /
			else if ($method == "stateCalled" || $method == "stateCalledAll") {
				if ($method == "stateCalledAll") {
					$method = "stateCalled";
				}
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method))
					echo "<script>goTo(\"/login/1\");</script>";	
				else {
					/*
					 * Insert your foreign key here
					 * /
					if ($where != "")
						$where .= " AND unidade_especializacoes.@_FOREIGN_KEY = " . $base;
					else 
						$where = "unidade_especializacoes.@_FOREIGN_KEY = " . $base;
						
					$daoFactory->beginTransaction();
					$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
					$response["unidade_especializacoes"] = $daoFactory->getUnidade_especializacoesDao()->read($where, $limit, true);
					if (!is_array($response["unidade_especializacoes"])) {
						$response["data_not_found"][0]["value"] = "<p>Não possui registro.</p>";
					}
					$daoFactory->close();

					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", getMenu($daoFactory, $_USER, $screen));
					echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_especializacoes/unidade_especializacoesCLL.html", $response);
				}
			}

			/*
			 * Screen
			 * /
			else if ($method == "screen") {
				if ($base != "") {
					$arrBase = explode("<gz>", $base);
					
					if (sizeof($arrBase) > 1) {
						if ($where != "")
							$where .= " AND unidade_especializacoes.@_FOREIGN_KEY = " . $arrBase[1];
						else
							$where = "unidade_especializacoes.@_FOREIGN_KEY = " . $arrBase[1];
					}
				}
				
				$limit = "unidade_especializacoes.id DESC LIMIT " . (($position * 5) - 5) . ", 5";

				$daoFactory->beginTransaction();
				$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", true);
				$response["unidade_especializacoes"] = $daoFactory->getUnidade_especializacoesDao()->read($where, $limit, true);
				$daoFactory->close();

				echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_especializacoes/unidade_especializacoesSCR.html", $response) . 
						"<size>" . (is_array($response["unidade_especializacoes"]) ? $response["unidade_especializacoes"][0]["unidade_especializacoes.size"] : 0) . "<theme>455a64";
			}

			/*
			 * Screen handler
			 * /
			else if ($method == "screenHandler") {	
				$where = "";

				// Get value from combo
				$cmb = explode("<gz>", $search);

				if ($cmb[1] != "")
					$where = "unidade_especializacoes.id = " . $cmb[1];

				$daoFactory->beginTransaction();
				$response["unidade_especializacoes"] = $daoFactory->getUnidade_especializacoesDao()->comboScr($where);
				$daoFactory->close();

				echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_especializacoes/unidade_especializacoesCMB.html", $response);
			}

			/*
			 * Create
			 * /
			else if ($method == "create") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method)) {
					$response["message"] = "permission";
					
					echo $view->json($response);
				} else {
					$unidade_especializacoes = new model\Unidade_especializacoes();
					$unidade_especializacoes->setEspecializacao(logicNull($form[0]));
					$unidade_especializacoes->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_especializacoes->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_especializacoes->setUnidade($form[1]);
					
					$daoFactory->beginTransaction();
					$resultDao = $daoFactory->getUnidade_especializacoesDao()->create($unidade_especializacoes);

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
			 * /
			else if ($method == "update") {	
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method)) {
					$response["message"] = "permission";
					
					echo $view->json($response);
				} else {
					$unidade_especializacoes = new model\Unidade_especializacoes();
					$unidade_especializacoes->setId($code);
					$unidade_especializacoes->setEspecializacao(logicNull($form[0]));
					$unidade_especializacoes->setCadastrado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_especializacoes->setModificado(date("Y-m-d H:i:s", (time() - 3600 * 3)));
					$unidade_especializacoes->setUnidade($form[1]);
					
					$daoFactory->beginTransaction();
					$resultDao = $daoFactory->getUnidade_especializacoesDao()->update($unidade_especializacoes);

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
			 * /
			else if ($method == "delete") {
				if (!getPermission($_ROOT . $_MODULE, $daoFactory, $screen, $method)) {
					$response["message"] = "permission";
					
					echo $view->json($response);
				} else {
					$result = true;
					$lines = explode("<gz>", $code);

					$daoFactory->beginTransaction();

					for ($i = 1; $i < sizeof($lines); $i++) {
						$where = "unidade_especializacoes.id = " . $lines[$i];
						
						$resultDao = $daoFactory->getUnidade_especializacoesDao()->delete($where);
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
*/
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

	if ($method == "page") {
		$response["data"] = callAPI("/plantoes-autorizados", []);
		$response["content"] = responseAPI($response["data"][0]["content"]);
	/** 	var_dump($response["content"]); */
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/header.html");
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/unidade_especializacoes.html", $response);
		echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/footer.html");
	}
?>