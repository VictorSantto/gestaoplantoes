<?php 
			
	/**
	 * Generated by Getz Framework
	 * 
	 * @author Mario Sakamoto <mskamot@gmail.com>
	 * @see https://wtag.com.br/getz
	 */
	 
	namespace src\model; 

	class Tipos_permissoes {
			
		private $id;
		private $tipo_permissao;
		private $cadastrado;
		private $modificado;
		private $cor;
			
		public function __construct() { }
			
		public function setId($id) {
			$this->id = $id;
		}
		
		public function getId() {
			return $this->id;
		}
					
		public function setTipo_permissao($tipo_permissao) {
			$this->tipo_permissao = $tipo_permissao;
		}
		
		public function getTipo_permissao() {
			return $this->tipo_permissao;
		}
					
		public function setCadastrado($cadastrado) {
			$this->cadastrado = $cadastrado;
		}
		
		public function getCadastrado() {
			return $this->cadastrado;
		}
					
		public function setModificado($modificado) {
			$this->modificado = $modificado;
		}
		
		public function getModificado() {
			return $this->modificado;
		}
					
		public function setCor($cor) {
			$this->cor = $cor;
		}
		
		public function getCor() {
			return $this->cor;
		}
					
	}
	
?>