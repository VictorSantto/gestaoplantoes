<?php
			
	/**
	 * Generated by Getz Framework
	 * 
	 * @author Mario Sakamoto <mskamot@gmail.com>
	 * @see https://wtag.com.br/getz 
	 */
	 
	namespace src\model; 
	
	use src\model;
	
	class Menu_submenusDao {
	
		private $connection;
		
		/*
		 * Constant variables
		 */
		private $create = "INSERT INTO menu_submenus (
				menu_submenu
				, link
				, ordem
				, cadastrado
				, modificado
				, menu
				, situacao_registro
				) VALUES";
				
		public $read = 
				"menu_submenus.id AS \"menu_submenus.id\"
				, menu_submenus.menu_submenu AS \"menu_submenus.menu_submenu\"
				, menu_submenus.link AS \"menu_submenus.link\"
				, menu_submenus.ordem AS \"menu_submenus.ordem\"
				, menu_submenus.cadastrado AS \"menu_submenus.cadastrado\"
				, menu_submenus.modificado AS \"menu_submenus.modificado\"
				, menu_submenus.menu AS \"menu_submenus.menu\"
				, menu_submenus.situacao_registro AS \"menu_submenus.situacao_registro\"
				";
				
		private $update = "UPDATE menu_submenus SET";
		private $delete = "DELETE FROM menu_submenus";
		
		public $from = "menu_submenus menu_submenus";
		
		/*
		 * Parameters
		 */
		private $where;
		private $order;
		
		// Dynamic query
		private $sql;
		
		// Controller response
		private $response;	
		
		/**
		 * @param {Object} connection
		 */
		public function __construct($connection) {
			$this->connection = $connection;
		}

		/**
		 * @param {Menu_submenus}menu_submenus
		 */
		public function setCreate($menu_submenus) {		
			$this->sql = $this->create . " (\"" . 
					$menu_submenus->getMenu_submenu() .
					"\", \"" . $menu_submenus->getLink() .
					"\", \"" . $menu_submenus->getOrdem() .
					"\", \"" . $menu_submenus->getCadastrado() .
					"\", \"" . $menu_submenus->getModificado() .
					"\", \"" . $menu_submenus->getMenu() .
					"\", \"" . $menu_submenus->getSituacao_registro() .
					"\")";
		}
		
		/**
		 * @return {String}
		 */
		public function getCreate() {
			return $this->sql;
		}	
		
		/**
		 * @param {String} where
		 * @param {String} order
		 */
		public function setRead($where, $order) {
			$menusDao = new model\MenusDao($this->connection);
			$situacoes_registrosDao = new model\Situacoes_registrosDao($this->connection);
			
			$this->setWhere($where);
			$this->setOrder($order);
			
			$this->sql = "SELECT " . $this->read . ", " . $menusDao->read . ", " . $situacoes_registrosDao->read . 
					" FROM " . $this->getFrom() .", " . $menusDao->from . ", " . $situacoes_registrosDao->from . 
					($this->getWhere() == "" ? " WHERE menu_submenus.menu = menus.id AND menu_submenus.situacao_registro = situacoes_registros.id" : $this->getWhere()) . 
					" AND menu_submenus.menu = menus.id AND menu_submenus.situacao_registro = situacoes_registros.id" . $this->getOrder();
		}
		
		/**
		 * @return {String}
		 */
		public function getRead() {
			return $this->sql;
		}
		
		/**
		 * @param {Menu_submenus}menu_submenus  
		 * @param {String} where
		 */
		public function setUpdate($menu_submenus, $where) {
			$this->setWhere($where);
			
			$this->sql = $this->update . 
					" id = \"" . $menu_submenus->getId() . 
					"\", menu_submenu = \"" . $menu_submenus->getMenu_submenu() . 
					"\", link = \"" . $menu_submenus->getLink() . 
					"\", ordem = \"" . $menu_submenus->getOrdem() . 
					"\", modificado = \"" . $menu_submenus->getModificado() . 
					"\", menu = \"" . $menu_submenus->getMenu() . 
					"\", situacao_registro = \"" . $menu_submenus->getSituacao_registro() . 
					"\"" . $this->getWhere();
		}
		
		/**
		 * @return {String}
		 */
		public function getUpdate() {
			return $this->sql;
		}
		
		/**
		 * @param {String} where
		 */
		public function setDelete($where) {	
			$this->setWhere($where);
			
			$this->sql = $this->delete . $this->getWhere();
		}
		
		/**
		 * @return {String}
		 */
		public function getDelete() {
			return $this->sql;
		}
		
		/**
		 * @return {String}
		 */
		public function getFrom() {
			return $this->from;
		}
		
		/**
		 * @param {String} where
		 */
		public function setWhere($where) {
			if ($where != "")
				$this->where = " WHERE " . $where;
			else
				$this->where = "";
		}
		
		/**
		 * @return {String}
		 */
		public function getWhere() {
			return $this->where;
		}
		
		/**
		 * @param {String} order
		 */
		public function setOrder($order) {
			if ($order != "")
				$this->order = " ORDER BY " . $order;
			else
				$this->order = "";
		}
		
		/**
		 * @return {String}
		 */
		public function getOrder() {
			return $this->order;
		}
		
		/**
		 * @param {Integer} line
		 * @param column String
		 * @param value String
		 */
		private function setResponse($line, $column, $value) {
			$this->response[$line][$column] = $value;
		}

		/**
		 * @return {Array}
		 */
		private function getResponse() {
			return $this->response;
		}

		/**
		 * @param {String} where
		 */
		private function setSize($where) {
			$this->setWhere($where);
			
			$result = $this->connection->execute(
					"SELECT count(1) AS \"menu_submenus.size\" from menu_submenus" . $this->getWhere());

			while ($row = $result->fetch_assoc()) {		
				$this->setResponse(0, "menu_submenus.size", $row["menu_submenus.size"]);
				
				$pages = ceil($row["menu_submenus.size"] / $this->connection->getItensPerPage());
				
				$this->setResponse(0, "menu_submenus.page", $this->connection->getPosition());
				$this->setResponse(0, "menu_submenus.pages", $pages);
				
				$pagination = "<select id='gz-select-pagination' onchange='goPage();'>";
				
				for ($i = 1; $i <= $pages; $i++) {
					if ($i == $this->connection->getPosition())
						$pagination .= "<option value='" . $i . "' selected>" . $i . "</option>";
					else
						$pagination .= "<option value='" . $i . "'>" . $i . "</option>";
				}	

				$pagination .= "</select>";
						
				$this->setResponse(0, "menu_submenus.pagination", $pagination);
			}

			$this->connection->free($result);
		}
		
		/**
		 * @param {Integer} line
		 */
		public function setDivLine($line) {
			$this->setResponse($line - 1, "@_START_LINE_TWO", modelStartLine($line, 2));
			$this->setResponse($line - 1, "@_END_LINE_TWO", modelEndLine($line, 2));

			$this->setResponse($line - 1, "@_START_LINE_THREE", modelStartLine($line, 3));
			$this->setResponse($line - 1, "@_END_LINE_THREE", modelEndLine($line, 3));
			
			$this->setResponse($line - 1, "@_START_LINE_FOUR", modelStartLine($line, 4));
			$this->setResponse($line - 1, "@_END_LINE_FOUR", modelEndLine($line, 4));
		}
		
		/**
		 * @param {Integer} line
		 */
		public function checkDivLine($line) {
			if (modelCheckEndLine($line, 2) != "")
				$this->setResponse($line - 1, "@_END_LINE_TWO", modelCheckEndLine($line, 2));
			
			if (modelCheckEndLine($line, 3) != "")
				$this->setResponse($line - 1, "@_END_LINE_THREE", modelCheckEndLine($line, 3));		

			if (modelCheckEndLine($line, 4) != "")
				$this->setResponse($line - 1, "@_END_LINE_FOUR", modelCheckEndLine($line, 4));			
		}	

		/**
		 * @param {String} log
		 */
		private function setLog($log) {
			$this->setResponse(0, "log", $log);
		}
		
		/**
		 * @param {Menu_submenus} menu_submenus 
		 * @return {Boolean}
		 */
		public function create($menu_submenus) {
			$result = "";

			$this->setCreate($menu_submenus);
			$result = $this->connection->execute($this->getCreate());
			
			return $result;
		}

		/**
		 * @param {String} where
		 * @param {String} order
		 * @param {Boolean} wp
		 * @param {Array}
		 */
		public function read($where, $order, $wp) {
			$line = 0;

			$this->setRead($where, $order);
			$result = $this->connection->execute($this->getRead());

			while ($row = $result->fetch_assoc()) {
				$this->setResponse($line, "menu_submenus.id", $row["menu_submenus.id"]);
				$this->setResponse($line, "menu_submenus.menu_submenu", $row["menu_submenus.menu_submenu"]);
				$this->setResponse($line, "menu_submenus.menu_submenu.format.json", modelDoubleQuotesJson($row["menu_submenus.menu_submenu"]));
				$this->setResponse($line, "menu_submenus.menu_submenu.format", modelDoubleQuotes($row["menu_submenus.menu_submenu"]));
				$this->setResponse($line, "menu_submenus.menu_submenu.view", addLine($row["menu_submenus.menu_submenu"]));
				$this->setResponse($line, "menu_submenus.link", $row["menu_submenus.link"]);
				$this->setResponse($line, "menu_submenus.link.format.json", modelDoubleQuotesJson($row["menu_submenus.link"]));
				if ($row["menu_submenus.link"] == "") {
					$this->setResponse($line, "menu_submenus.link.view", "");
				} else {
					if (substr($row["menu_submenus.link"], 0, 1) == "/") {
						$this->setResponse($line, "menu_submenus.link.view", "href=\"@_ROOT" . $row["menu_submenus.link"] . "\"");
					} else {
						$this->setResponse($line, "menu_submenus.link.view", "href=\"" . $row["menu_submenus.link"] . "\" target=\"_blank\"");
					}
				}
				$this->setResponse($line, "menu_submenus.ordem", $row["menu_submenus.ordem"]);
				$this->setResponse($line, "menu_submenus.cadastrado", modelDateTime($row["menu_submenus.cadastrado"]));
				$this->setResponse($line, "menu_submenus.modificado", modelDateTime($row["menu_submenus.modificado"]));
				$this->setResponse($line, "menu_submenus.menu", $row["menu_submenus.menu"]);
				$this->setResponse($line, "menus.menu", $row["menus.menu"]);
				$this->setResponse($line, "menu_submenus.situacao_registro", $row["menu_submenus.situacao_registro"]);
				$this->setResponse($line, "situacoes_registros.situacao_registro", $row["situacoes_registros.situacao_registro"]);
			
				$this->setResponse($line, "menu_submenus.line", $line);
			
				$line++;
				
				if ($wp)
					$this->setDivLine($line);
			}

			$this->connection->free($result);
			
			if ($wp && $line > 0) {
				$this->checkDivLine($line);
				
				$this->setSize($where);
			}

			return $this->getResponse();
		}

		/**
		 * @param {Menu_submenus} menu_submenus 
		 * @return {Boolean}
		 */
		public function update($menu_submenus) {
			$result = "";
			
			$this->setUpdate($menu_submenus, "menu_submenus.id = " . $menu_submenus->getId());
			$result = $this->connection->execute($this->getUpdate());

			return $result;
		}

		/**
		 * @param {String} where
		 * @return {Boolean}
		 */
		public function delete($where) {
			$result = "";
			
			$this->setDelete($where);
			$result = $this->connection->execute($this->getDelete());

			return $result;
		}
		
		/**
		 * @param {Integer} selected
		 * @param {String} order
		 * @return {Array}
		 */
		public function combo($selected, $order) {
			$size = 0;

			$this->setRead("", $order);
			$result = $this->connection->execute($this->getRead());

			while ($row = $result->fetch_assoc()) {
				$this->setResponse($size, "menu_submenus.id", $row["menu_submenus.id"]);
				$this->setResponse($size, "menu_submenus.menu_submenu", $row["menu_submenus.menu_submenu"]);
			
				if ($row["menu_submenus.id"] == $selected)
					$this->setResponse($size, "menu_submenus.selected", "selected");
				else
					$this->setResponse($size, "menu_submenus.selected", "");
					
				$size++;
			}
			
			$this->connection->free($result);
			
			$this->setResponse(0, "size", $size);

			return $this->getResponse();
		}
		
		/**
		 * @param {String} where
		 * @return {Array}
		 */
		public function comboScr($where) {
			$size = 0;

			$this->setRead($where, "");
			$result = $this->connection->execute($this->getRead());

			while ($row = $result->fetch_assoc()) {
				$this->setResponse($size, "menu_submenus.id", $row["menu_submenus.id"]);
				$this->setResponse($size, "menu_submenus.menu_submenu", $row["menu_submenus.menu_submenu"]);
				$this->setResponse($size, "menu_submenus.selected", "selected");
					
				$size++;
			}
			
			$this->connection->free($result);
			
			$this->setResponse(0, "size", $size);

			return $this->getResponse();
		}

	}

?>