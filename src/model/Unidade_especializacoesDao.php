<?php
			
	/**
	 * Generated by Getz Framework
	 * 
	 * @author Mario Sakamoto <mskamot@gmail.com>
	 * @see https://wtag.com.br/getz 
	 */
	 
	namespace src\model; 
	
	use src\model;
	
	class Unidade_especializacoesDao {
	
		private $connection;
		
		/*
		 * Constant variables
		 */
		private $create = "INSERT INTO unidade_especializacoes (
				unidade_especializacao
				, cadastrado
				, modificado
				, unidade
				) VALUES";
				
		public $read = 
				"unidade_especializacoes.id AS \"unidade_especializacoes.id\"
				, unidade_especializacoes.unidade_especializacao AS \"unidade_especializacoes.unidade_especializacao\"
				, unidade_especializacoes.cadastrado AS \"unidade_especializacoes.cadastrado\"
				, unidade_especializacoes.modificado AS \"unidade_especializacoes.modificado\"
				, unidade_especializacoes.unidade AS \"unidade_especializacoes.unidade\"
				";
				
		private $update = "UPDATE unidade_especializacoes SET";
		private $delete = "DELETE FROM unidade_especializacoes";
		
		public $from = "unidade_especializacoes unidade_especializacoes";
		
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
		 * @param {Unidade_especializacoes}unidade_especializacoes
		 */
		public function setCreate($unidade_especializacoes) {		
			$this->sql = $this->create . " (\"" . 
					$unidade_especializacoes->getUnidade_especializacao() .
					"\", \"" . $unidade_especializacoes->getCadastrado() .
					"\", \"" . $unidade_especializacoes->getModificado() .
					"\", \"" . $unidade_especializacoes->getUnidade() .
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
			$unidadesDao = new model\UnidadesDao($this->connection);
			
			$this->setWhere($where);
			$this->setOrder($order);
			
			$this->sql = "SELECT " . $this->read . ", " . $unidadesDao->read . 
					" FROM " . $this->getFrom() .", " . $unidadesDao->from . 
					($this->getWhere() == "" ? " WHERE unidade_especializacoes.unidade = unidades.id" : $this->getWhere()) . 
					" AND unidade_especializacoes.unidade = unidades.id" . $this->getOrder();
		}
		
		/**
		 * @return {String}
		 */
		public function getRead() {
			return $this->sql;
		}
		
		/**
		 * @param {Unidade_especializacoes}unidade_especializacoes  
		 * @param {String} where
		 */
		public function setUpdate($unidade_especializacoes, $where) {
			$this->setWhere($where);
			
			$this->sql = $this->update . 
					" id = \"" . $unidade_especializacoes->getId() . 
					"\", unidade_especializacao = \"" . $unidade_especializacoes->getUnidade_especializacao() . 
					"\", modificado = \"" . $unidade_especializacoes->getModificado() . 
					"\", unidade = \"" . $unidade_especializacoes->getUnidade() . 
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
					"SELECT count(1) AS \"unidade_especializacoes.size\" from unidade_especializacoes" . $this->getWhere());

			while ($row = $result->fetch_assoc()) {		
				$this->setResponse(0, "unidade_especializacoes.size", $row["unidade_especializacoes.size"]);
				
				$pages = ceil($row["unidade_especializacoes.size"] / $this->connection->getItensPerPage());
				
				$this->setResponse(0, "unidade_especializacoes.page", $this->connection->getPosition());
				$this->setResponse(0, "unidade_especializacoes.pages", $pages);
				
				$pagination = "<select id='gz-select-pagination' onchange='goPage();'>";
				
				for ($i = 1; $i <= $pages; $i++) {
					if ($i == $this->connection->getPosition())
						$pagination .= "<option value='" . $i . "' selected>" . $i . "</option>";
					else
						$pagination .= "<option value='" . $i . "'>" . $i . "</option>";
				}	

				$pagination .= "</select>";
						
				$this->setResponse(0, "unidade_especializacoes.pagination", $pagination);
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
		 * @param {Unidade_especializacoes} unidade_especializacoes 
		 * @return {Boolean}
		 */
		public function create($unidade_especializacoes) {
			$result = "";

			$this->setCreate($unidade_especializacoes);
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
				$this->setResponse($line, "unidade_especializacoes.id", $row["unidade_especializacoes.id"]);
				$this->setResponse($line, "unidade_especializacoes.unidade_especializacao", $row["unidade_especializacoes.unidade_especializacao"]);
				$this->setResponse($line, "unidade_especializacoes.unidade_especializacao.format.json", modelDoubleQuotesJson($row["unidade_especializacoes.unidade_especializacao"]));
				$this->setResponse($line, "unidade_especializacoes.unidade_especializacao.format", modelDoubleQuotes($row["unidade_especializacoes.unidade_especializacao"]));
				$this->setResponse($line, "unidade_especializacoes.unidade_especializacao.view", addLine($row["unidade_especializacoes.unidade_especializacao"]));
				$this->setResponse($line, "unidade_especializacoes.cadastrado", modelDateTime($row["unidade_especializacoes.cadastrado"]));
				$this->setResponse($line, "unidade_especializacoes.modificado", modelDateTime($row["unidade_especializacoes.modificado"]));
				$this->setResponse($line, "unidade_especializacoes.unidade", $row["unidade_especializacoes.unidade"]);
				$this->setResponse($line, "unidades.unidade", $row["unidades.unidade"]);
			
				$this->setResponse($line, "unidade_especializacoes.line", $line);
			
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
		 * @param {Unidade_especializacoes} unidade_especializacoes 
		 * @return {Boolean}
		 */
		public function update($unidade_especializacoes) {
			$result = "";
			
			$this->setUpdate($unidade_especializacoes, "unidade_especializacoes.id = " . $unidade_especializacoes->getId());
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
				$this->setResponse($size, "unidade_especializacoes.id", $row["unidade_especializacoes.id"]);
				$this->setResponse($size, "unidade_especializacoes.unidade_especializacao", $row["unidade_especializacoes.unidade_especializacao"]);
			
				if ($row["unidade_especializacoes.id"] == $selected)
					$this->setResponse($size, "unidade_especializacoes.selected", "selected");
				else
					$this->setResponse($size, "unidade_especializacoes.selected", "");
					
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
				$this->setResponse($size, "unidade_especializacoes.id", $row["unidade_especializacoes.id"]);
				$this->setResponse($size, "unidade_especializacoes.unidade_especializacao", $row["unidade_especializacoes.unidade_especializacao"]);
				$this->setResponse($size, "unidade_especializacoes.selected", "selected");
					
				$size++;
			}
			
			$this->connection->free($result);
			
			$this->setResponse(0, "size", $size);

			return $this->getResponse();
		}

	}

?>