<?php
			
	/**
	 * Generated by Getz Framework
	 * 
	 * @author Mario Sakamoto <mskamot@gmail.com>
	 * @see https://wtag.com.br/getz 
	 */
	 
	namespace src\model; 
	
	use src\model;
	
	class UsuariosDao {
	
		private $connection;
		
		/*
		 * Constant variables
		 */
		private $create = "INSERT INTO usuarios (
				usuario
				, cpf
				, email
				, senha
				, foto
				, access_token
				, access_token_expiration
				, password_token
				, password_token_expiration
				, activation_token
				, activation_token_expiration
				, cadastrado
				, modificado
				, situacao_registro
				, perfil
				) VALUES";
				
		public $read = 
				"usuarios.id AS \"usuarios.id\"
				, usuarios.usuario AS \"usuarios.usuario\"
				, usuarios.cpf AS \"usuarios.cpf\"
				, usuarios.email AS \"usuarios.email\"
				, usuarios.senha AS \"usuarios.senha\"
				, usuarios.foto AS \"usuarios.foto\"
				, usuarios.access_token AS \"usuarios.access_token\"
				, usuarios.access_token_expiration AS \"usuarios.access_token_expiration\"
				, usuarios.password_token AS \"usuarios.password_token\"
				, usuarios.password_token_expiration AS \"usuarios.password_token_expiration\"
				, usuarios.activation_token AS \"usuarios.activation_token\"
				, usuarios.activation_token_expiration AS \"usuarios.activation_token_expiration\"
				, usuarios.cadastrado AS \"usuarios.cadastrado\"
				, usuarios.modificado AS \"usuarios.modificado\"
				, usuarios.situacao_registro AS \"usuarios.situacao_registro\"
				, usuarios.perfil AS \"usuarios.perfil\"
				";
				
		private $update = "UPDATE usuarios SET";
		private $delete = "DELETE FROM usuarios";
		
		public $from = "usuarios usuarios";
		
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
		 * @param {Usuarios}usuarios
		 */
		public function setCreate($usuarios) {		
			$this->sql = $this->create . " (\"" . 
					$usuarios->getUsuario() .
					"\", \"" . $usuarios->getCpf() .
					"\", \"" . $usuarios->getEmail() .
					"\", \"" . $usuarios->getSenha() .
					"\", \"" . $usuarios->getFoto() .
					"\", \"" . $usuarios->getAccess_token() .
					"\", \"" . $usuarios->getAccess_token_expiration() .
					"\", \"" . $usuarios->getPassword_token() .
					"\", \"" . $usuarios->getPassword_token_expiration() .
					"\", \"" . $usuarios->getActivation_token() .
					"\", \"" . $usuarios->getActivation_token_expiration() .
					"\", \"" . $usuarios->getCadastrado() .
					"\", \"" . $usuarios->getModificado() .
					"\", \"" . $usuarios->getSituacao_registro() .
					"\", \"" . $usuarios->getPerfil() .
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
			$situacoes_registrosDao = new model\Situacoes_registrosDao($this->connection);
			$perfisDao = new model\PerfisDao($this->connection);
			
			$this->setWhere($where);
			$this->setOrder($order);
			
			$this->sql = "SELECT " . $this->read . ", " . $situacoes_registrosDao->read . ", " . $perfisDao->read . 
					" FROM " . $this->getFrom() .", " . $situacoes_registrosDao->from . ", " . $perfisDao->from . 
					($this->getWhere() == "" ? " WHERE usuarios.situacao_registro = situacoes_registros.id AND usuarios.perfil = perfis.id" : $this->getWhere()) . 
					" AND usuarios.situacao_registro = situacoes_registros.id AND usuarios.perfil = perfis.id" . $this->getOrder();
		}
		
		/**
		 * @return {String}
		 */
		public function getRead() {
			return $this->sql;
		}
		
		/**
		 * @param {Usuarios}usuarios  
		 * @param {String} where
		 */
		public function setUpdate($usuarios, $where) {
			$this->setWhere($where);
			
			$this->sql = $this->update . 
					" id = \"" . $usuarios->getId() . 
					"\", usuario = \"" . $usuarios->getUsuario() . 
					"\", cpf = \"" . $usuarios->getCpf() . 
					"\", email = \"" . $usuarios->getEmail() . 
					"\", senha = \"" . $usuarios->getSenha() . 
					"\", foto = \"" . $usuarios->getFoto() . 
					"\", access_token = \"" . $usuarios->getAccess_token() . 
					"\", access_token_expiration = \"" . $usuarios->getAccess_token_expiration() . 
					"\", password_token = \"" . $usuarios->getPassword_token() . 
					"\", password_token_expiration = \"" . $usuarios->getPassword_token_expiration() . 
					"\", activation_token = \"" . $usuarios->getActivation_token() . 
					"\", activation_token_expiration = \"" . $usuarios->getActivation_token_expiration() . 
					"\", modificado = \"" . $usuarios->getModificado() . 
					"\", situacao_registro = \"" . $usuarios->getSituacao_registro() . 
					"\", perfil = \"" . $usuarios->getPerfil() . 
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
					"SELECT count(1) AS \"usuarios.size\" from usuarios" . $this->getWhere());

			while ($row = $result->fetch_assoc()) {		
				$this->setResponse(0, "usuarios.size", $row["usuarios.size"]);
				
				$pages = ceil($row["usuarios.size"] / $this->connection->getItensPerPage());
				
				$this->setResponse(0, "usuarios.page", $this->connection->getPosition());
				$this->setResponse(0, "usuarios.pages", $pages);
				
				$pagination = "<select id='gz-select-pagination' onchange='goPage();'>";
				
				for ($i = 1; $i <= $pages; $i++) {
					if ($i == $this->connection->getPosition())
						$pagination .= "<option value='" . $i . "' selected>" . $i . "</option>";
					else
						$pagination .= "<option value='" . $i . "'>" . $i . "</option>";
				}	

				$pagination .= "</select>";
						
				$this->setResponse(0, "usuarios.pagination", $pagination);
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
		 * @param {Usuarios} usuarios 
		 * @return {Boolean}
		 */
		public function create($usuarios) {
			$result = "";

			$this->setCreate($usuarios);
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
				$this->setResponse($line, "usuarios.id", $row["usuarios.id"]);
				$this->setResponse($line, "usuarios.usuario", $row["usuarios.usuario"]);
				$this->setResponse($line, "usuarios.usuario.format.json", modelDoubleQuotesJson($row["usuarios.usuario"]));
				$this->setResponse($line, "usuarios.usuario.format", modelDoubleQuotes($row["usuarios.usuario"]));
				$this->setResponse($line, "usuarios.usuario.view", addLine($row["usuarios.usuario"]));
				$this->setResponse($line, "usuarios.cpf", $row["usuarios.cpf"]);
				$this->setResponse($line, "usuarios.email", $row["usuarios.email"]);
				$this->setResponse($line, "usuarios.senha", $row["usuarios.senha"]);
				$this->setResponse($line, "usuarios.senha.format.json", modelDoubleQuotesJson($row["usuarios.senha"]));
				$this->setResponse($line, "usuarios.foto", $row["usuarios.foto"]);
				$this->setResponse($line, "usuarios.access_token", $row["usuarios.access_token"]);
				$this->setResponse($line, "usuarios.access_token.format.json", modelDoubleQuotesJson($row["usuarios.access_token"]));
				$this->setResponse($line, "usuarios.access_token_expiration", modelDateTime($row["usuarios.access_token_expiration"]));
				$this->setResponse($line, "usuarios.password_token", $row["usuarios.password_token"]);
				$this->setResponse($line, "usuarios.password_token.format.json", modelDoubleQuotesJson($row["usuarios.password_token"]));
				$this->setResponse($line, "usuarios.password_token_expiration", modelDateTime($row["usuarios.password_token_expiration"]));
				$this->setResponse($line, "usuarios.activation_token", $row["usuarios.activation_token"]);
				$this->setResponse($line, "usuarios.activation_token.format.json", modelDoubleQuotesJson($row["usuarios.activation_token"]));
				$this->setResponse($line, "usuarios.activation_token_expiration", modelDateTime($row["usuarios.activation_token_expiration"]));
				$this->setResponse($line, "usuarios.cadastrado", modelDateTime($row["usuarios.cadastrado"]));
				$this->setResponse($line, "usuarios.modificado", modelDateTime($row["usuarios.modificado"]));
				$this->setResponse($line, "usuarios.situacao_registro", $row["usuarios.situacao_registro"]);
				$this->setResponse($line, "situacoes_registros.situacao_registro", $row["situacoes_registros.situacao_registro"]);
				$this->setResponse($line, "usuarios.perfil", $row["usuarios.perfil"]);
				$this->setResponse($line, "perfis.perfil", $row["perfis.perfil"]);
				if ($row["usuarios.foto"] == "") {
					if (rand(1, 2) == 1) {
						$this->setResponse($line, "usuarios.foto", "male-user.svg");
					} else {
						$this->setResponse($line, "usuarios.foto", "female-user.svg");
					}
				}
			
				$this->setResponse($line, "usuarios.line", $line);
			
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
		 * @param {Usuarios} usuarios 
		 * @return {Boolean}
		 */
		public function update($usuarios) {
			$result = "";
			
			$this->setUpdate($usuarios, "usuarios.id = " . $usuarios->getId());
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
				$this->setResponse($size, "usuarios.id", $row["usuarios.id"]);
				$this->setResponse($size, "usuarios.usuario", $row["usuarios.usuario"]);
			
				if ($row["usuarios.id"] == $selected)
					$this->setResponse($size, "usuarios.selected", "selected");
				else
					$this->setResponse($size, "usuarios.selected", "");
					
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
				$this->setResponse($size, "usuarios.id", $row["usuarios.id"]);
				$this->setResponse($size, "usuarios.usuario", $row["usuarios.usuario"]);
				$this->setResponse($size, "usuarios.selected", "selected");
					
				$size++;
			}
			
			$this->connection->free($result);
			
			$this->setResponse(0, "size", $size);

			return $this->getResponse();
		}

	}

?>