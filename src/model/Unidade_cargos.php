<?php 
			
	/**
	 * Generated by Getz Framework
	 * 
	 * @author Mario Sakamoto <mskamot@gmail.com>
	 * @see https://wtag.com.br/getz
	 */
	 
	namespace src\model; 

	class Unidade_cargos {
			
		private $id;
		private $unidade_cargo;
		private $cadastrado;
		private $modificado;
		private $unidade;
			
		public function __construct() { }
			
		public function setId($id) {
			$this->id = $id;
		}
		
		public function getId() {
			return $this->id;
		}
					
		public function setUnidade_cargo($unidade_cargo) {
			$this->unidade_cargo = $unidade_cargo;
		}
		
		public function getUnidade_cargo() {
			return $this->unidade_cargo;
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
					
		public function setUnidade($unidade) {
			$this->unidade = $unidade;
		}
		
		public function getUnidade() {
			return $this->unidade;
		}
					
	}
	
?>