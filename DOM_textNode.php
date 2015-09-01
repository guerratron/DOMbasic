<?php
//define("TAG", "LinkClass");
	/**
	 * Clase para crear objetos de NODOS DE TEXTO para elementos del DOM, utiles para insertar texto 'innerHTML' dentro de los
	 * elementos del DOM.
	 **/
	class DOM_textNode extends DOM_element {
		const N_C = __CLASS__;
		protected $TAG = "";
		protected $TYPE = "textNode";
		protected $DESC = "inline DOM text element";
		/*
		 //APERTURA Y CIERRE DE ETIQUETAS DE ELEMENTO DOM. (algunos elementos autocontendidos (como '<img />') pueden modificarlas o
		 //incluso anularlas)		*/
		protected $OPEN_TAG_LEFT="";
		protected $OPEN_TAG_RIGHT="";
		protected $CLOSE_TAG_LEFT="";
		protected $CLOSE_TAG_RIGHT="";

		
		/**
		 * Texto que contiene este elemento.
		 **/
		protected $_text="";
		//-----------------  BEGIN: SINGLETON  --------------------
		/**
		 * PATRON ESTATICO SINGLETON
		 * @var DOM_textNode
		 * @access protected
		 */
		protected static $instance;
		
		/**
		 * PATRON SINGLETON. Tomar una instancia de forma estatica.<br />
		 * <code>$txt = DOM_textNode::getInstance();</code>
		 **/
		public static function getInstance() {
			//if (!isset(self::$instance)) {
			if (is_null(self::$instance)) {
				$c = __CLASS__;	//self::TAG
				//$instance = new $c;
				self::$instance = new $c();
			}
			return self::$instance;
		}
		//private function setInstance() {
		//self::$instance=$this;
		//}
		//-----------------  END: SINGLETON  --------------------
		
		//CONSTRUCTORES
		public function __construct($key=null){
			if($key != null) $this->_key=$key;
			self::$instance=$this;
		}
		/*
		 public static function __set_state($an_array) // A partir de PHP 5.1.0
		{
		return parent::__set_state($an_array);
		}
		*/

		//OVERRIDE: se sobreescribe porque le afecta a __toString();
		public function getOpenTag(){
			return ($this->OPEN_TAG_LEFT . /*$this->TAG . parent::getAttribsStr() .*/ $this->OPEN_TAG_RIGHT);
		}
		
		//OVERRIDE: se sobreescribe porque es distinto, para no crear un bucle infinito;
		/**
		 * Metodo para establecer el texto de este elemento DOM.
		 * @param string $text para este elemento.
		 * @return string con el texto anterior.
		 **/
		public function setText($text){
			$textoAnterior="";
			try{
				$this->tryingWrite("[".$this->_key."]".$this->TAG);
				$textoAnterior=$this->_text;
				$this->_text=addslashes( htmlspecialchars( $text ) );
				//$this->_text=addslashes( htmlspecialchars( $text, ENT_NOQUOTES ) );
				//$this->_text= $text ;
				//parent::setText($text);	//NO ACTIVAR PROVOCA BUCLE INFINITO!!
			}catch(Exception $e){
				$this->writeLog($e->getMessage(), $e->getTrace());
			}
			//return $textoAnterior;
			return $this;
		}

	}
?>