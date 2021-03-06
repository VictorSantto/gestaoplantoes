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
	
	if (!getActiveSession($_ROOT . $_MODULE))
		echo "<script>goTo(\"/login/1\");</script>";
	else {
		if ($method == "stateRead") {	
			$daoFactory->beginTransaction();
			$response["titles"] = $daoFactory->getTelasDao()->read("telas.identificador = \"" . $screen . "\"", "", 
					true);
			$daoFactory->close();
			echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/menus/menusCST.html", 
					getMenu($daoFactory, $_USER, $screen));
			echo $view->parse($_DOCUMENT_ROOT . $_PACKAGE . "/html/dashboard/dashboardCST.html", $response);
		}
	}

?>