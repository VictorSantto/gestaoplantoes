<?php 
			
	/**
	 * Generated by Getz Framework
	 * 
	 * @author Mario Sakamoto <mskamot@gmail.com>
	 * @see https://wtag.com.br/getz
	 */
	 
	namespace src\model; 

	class Unidade_especializacoes {
			
		private $id;
		private $unidade_especializacao;
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
					
		public function setUnidade_especializacao($unidade_especializacao) {
			$this->unidade_especializacao = $unidade_especializacao;
		}
		
		public function getUnidade_especializacao() {
			return $this->unidade_especializacao;
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