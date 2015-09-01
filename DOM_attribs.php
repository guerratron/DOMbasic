<?php
//define("TAG", "LinkClass");
/*
 * //SE ACONSEJA ESCRIBIR UNA FUNCION COMO ESTA DE 'AUTOCARGA' EN EL SCRIPT LLAMADOR
 * //PARA EVITAR CARGAR UNA A UNA CADA LLAMADA A include ...
		// we've writen this code where we need
		function __autoload($classname) {
			$ruta="./clases";
			$filename = $ruta."/". $classname .".php";
			try{
				include_once($filename);
				parent::__autoload($classname);
			} catch (Exception $e){
				throw new Exception("Imposible cargar $classname desde el directorio $ruta. ERROR: ".$e->getMessage().PHP_EOL);
			}
		} 
 */
//TODO:IMPORTANTE: SI ES UNA CLASE HEREDADA SE DEBE ASEGURAR ANTES DE ELLA QUE LA CLASE PADRE SE ENCUENTRA CARGADA
	/**
	 * Interfaz para crear atributos de elementos DOM. Para que objetos derivados del DOM (como links, ...) implementen atributos HTML.
	 * <p>El programador debe asegurarse que son nombres estandarizados para los atributos de elementos DOM. (W3C)</p>
	 * <p><span title="Filtrado futuro." style="color:navy; background:yellow;">TODO</span>: FILTRADO: 
	 * <del>Solo se admitiran nombres estandarizados para los atributos de elementos DOM. (W3C)</del></p>
	 * <p>Admite CONCATENACION DE METODOS mediante el retorno de la construccion '$this' en todos los metodos 'NO-GETTER': 
	 * &hellip; <code>$this->setAttrib('href','http://www.uno.com/')->removeAttrib('href');</code> &hellip;</p>
	 **/
	abstract class DOM_attribs implements IteratorAggregate, ArrayAccess {
		//private static final $TAG="LinkClass";
		/**
		 * <h1>Name Class</h1>
		 * Constante de cadena que representa el nombre de esta Clase, util para labores de Depuracion 
		 * (agregandola a las sentencias del log o de trade...)
		 * @var String constant
		 * @access public
		 */
		const N_C = __CLASS__; //__CLASS__ -> problemas en PHP 4 (letras minusculas)
		/**
		 * NORMA DE CODIFICACION URL. (espacios=+)
		 * @var String
		 */
		const ENCODE_RFC_1738="RFC_1738";
		/**
		 * NORMA DE CODIFICACION URL. (espacios=%20)
		 * @var String
		 */
		const ENCODE_RFC_3986="RFC_3986";
		
		//------------  BEGIN: CONFIGURACION  -----------------
		/**
		 * <h1>Boolean indicando si los atributos de este elemento son DE SOLO LECTURA O ESCRIBIBLES.</h1>
		 * @var boolean
		 * @access protected
		 */
		protected $_READ_ONLY=false;//=boolean;
		//---- BEGIN: AVISOS ------
		/**
		 * ¿ Lanzar Aviso cuando se lee un atributo que no existe ?
		 **/
		protected $AVISO_GET=false;
		//---- END: AVISOS ------
		
		//------------ END: CONFIGURACION ------------------------
		
		/**
		 * <h1>Array Asociativo (clave=>valor) de atributos DOM.</h1>
		 * ATRIBUTOS DOM	(PARA METODOS MAGICOS): Se le pueden agregar propiedades, atributos o campos dinamicamente
		 * @var Array Asociativo
		 * @access protected
		 */
		protected $_attribs=array();


		//CONSTRUCTORES
		/*	DESACONSEJADO A PARTIR DE PHP 5.3.3.3
		function DOM_attribs(){
			parent::__construct();
			$this->reinicializar();
		}
		*/
		/*
		 * <h1>CONSTRUCTOR PHP 4, Compatibilidad con PHP 4</h1>
		 * <p>El parametro sera un array asociativo de atributos con pares correctos 'clave=valor' de atributos DOM.</p>
		 **/
		/*
		function DOM_attribs($asocArrayAttribs=null) {
			if (version_compare(PHP_VERSION,"5.0.0","<")) {
				return $this->__construct($asocArrayAttribs);
			}
			//register_shutdown_function(array($this,"__destruct")); 
		}
		*/

		/**
		 * <h1>CONSTRUCTOR PHP 5, CON ENTREGA DIRECTA DE ATRIBUTOS.</h1>
		 * <p>El parametro sera un array asociativo de atributos con pares correctos 'clave=valor'.</p>
		 * <p>El programador debe asegurarse que son nombres estandarizados para los atributos de elementos DOM.(W3C)</p>
		 * <p><span title="Filtrado futuro." style="color:navy; background:yellow;">TODO</span>: FILTRADO:
		 * <del>Solo se admitiran nombres estandarizados para los atributos de elementos DOM. (W3C)</del></p>
		 * @param $asocArrayAttribs Array de pares 'clave=valor' de atributos DOM.
		 **/
		public function __construct($asocArrayAttribs=null){
			//$this->__autoload(self::TAG);
			//parent::__construct();
			//if($this->PATRON_SINGLETON) $this->setInstance();
			//$this->reinicializar();
			if(! is_null($asocArrayAttribs) ) $this->setAttribs($asocArrayAttribs);
		}
		public function __destruct(){
			//parent::__destruct();
			//self::$instance=null;
			$this->_attribs=null;
		}
		
		//--------------------  BEGIN: METODOS ABSTRACTOS  -------------------------
		/**
		 * <p>Establece si los atributos de este elemento son DE SOLO LECTURA O ESCRIBIBLES.</p>
		 * @param boolean
		 * @return DOM_element $this este elemento (DOM).
		 **/
		abstract function setReadOnly($readOnly);
		/**
		 * <p>Comprueba si los atributos de este elemento son DE SOLO LECTURA O ESCRIBIBLES.</p>
		 * @return boolean
		 **/
		abstract function getReadOnly();
		/**
		 * <p>Pone a cero los elementos de arrays de este Objeto.</p>
		 * @return DOM_element $this este elemento (DOM).
		 **/
		abstract function reinicializar();//{
			//$this->_attribs=array();
			//TODO: ¡¡OJO NO ACTIVAR!! PUEDE PROVOCAR UNA EXCEPCION AL SER LLAMADA DESDE UN CONSTRUCTOR.
			//register_shutdown_function(array($this, '__destruct'));	//para evitar un bug en PHP 5.3.10 con la destruccion de objetos
		//}
		
		//--------------------  END: METODOS ABSTRACTOS  -------------------------
		
		/**
		 * <p>Notifica una accion de escritura al objeto. Si es de solo-lectura lanzara una Excepcion.</p>
		 * @return boolean TRUE=OK, FALSE=throw DOMBasicAttribReadOnlyException()
		 * @throws DOMBasicAttribReadOnlyException;
		 **/
		protected function tryingWrite($arg="") {
			if($this->_READ_ONLY){
				//$mensaje="Intentando escribir en un Objeto de Solo-Lectura!!";
				throw new DOMBasicAttribReadOnlyException($arg, DOMBasicAttribReadOnlyException::READ);
				return false;
			}
			return true;
		}

		//public function __clone(){
				//return self::getInstance();
				//$clase=__CLASS__;	//self::TAG;
				//return new $clase($this->_attribs);	//DA ERRORES EN PHP 4.0
		//}
		
		/*
		// we've writen this code where we need
		function __autoload($classname) {
			$ruta="./clases";
			$filename = $ruta."/". $classname .".php";
			try{
				include_once($filename);
				parent::__autoload($classname);
			} catch (Exception $e){
				throw new Exception("Imposible cargar $classname desde el directorio $ruta. ERROR: ".$e->getMessage().PHP_EOL);
			}
		}
		*/

		
		//----------------- BEGIN: MAGICS METHODS ----------------------
		//AL RETORNAR UN ARRAY ES MEJOR HACERLO POR REFERENCIA PARA QUE SE MANTENGA ACTUALIZADO??
		/**
		 * Property get access.
		 * Simply returns a given attrib.
		 *
		 * @throws DOMAttribNotFoundException
		 *         If a the value for the property attrib is not an instance of
		 * @param string $attrib The name of the attrib to get.
		 * @return mixed The attrib value.
		 * @ignore
		 *
		 * @throws DOMBasicAttribNotFoundException
		 *         if the given property does not exist.
		 * @throws DOMBasicAttribReadOnlyException
		 *         if the attrib to be set is a write-only property.
		 */
		public function __get($attrib) {
		//public function &__get($attrib) {
			//echo "Consultando '$attrib'\n";
			try{
				if(is_null($this->_attribs) || count($this->_attribs)==0) {
					throw new DOMBasicAttribNotFoundException( $attrib );
					return null;
				}
				if (array_key_exists($attrib, $this->_attribs)) {
					//if ( $this->__isset( $attrib ) === true ){
					return $this->_attribs[$attrib];
				}
				throw new DOMBasicAttribNotFoundException( $attrib );
			}catch(Exception $e){
				if($this->AVISO_GET) self::writeLog($e->getMessage(), $e->getTrace());
				return "";
			}
			/*
			$trace = debug_backtrace();
			trigger_error(
			'"'. $self->TAG .'::__get() :> "Propiedad indefinida mediante __get(): ' . $name .
			' en ' . $trace[0]['file'] . ' en la línea ' . $trace[0]['line'],
			E_USER_NOTICE);
			*/
			return null;
		}
		/**
		 * Sets an attrib.
		 * This method is called when an attrib is set.
		 *
		 * @param string $attribName  The name of the attrib to set.
		 * @param mixed $attribValue The attrib value.
		 * @return DOM_element $this este elemento (DOM). (NO-UTIL)
		 * @ignore
		 *
		 * @throws DOMBasicAttribNotFoundException
		 *         if the given attrib does not exist.
		 * @throws DOMBasicValueException
		 *         if the value to be assigned to a attrib is invalid.
		 * @throws DOMBasicAttribReadOnlyException
		 *         if the attrib to be set is a read-only attrib.
		 */
		//abstract public function __set( $attribName, $attribValue );
		public function __set($attrib, $value) {
			//echo "Estableciendo '$attrib' a '$value'\n";
			try{	
				self::tryingWrite($attrib);
				$this->_attribs[$attrib] = $value;
			 }catch(Exception $e){
			 	self::writeLog($e->getMessage(), $e->getTrace());
			 }
			 return $this;
		}
		/**
		 * Returns if an attrib exists. (Desde PHP 5.1.0 )
		 *
		 * @param string $attrib Attrib name to check for.
		 * @return bool Whether the attrib exists.
		 * @ignore
		 */
		public function __isset($attrib) {
			//echo "¿Está definido '$attrib'?\n";
			//return isset($this->_attribs[$attrib]);
			return array_key_exists( $attrib, $this->_attribs );
		}
		
		/**  
		 * <h1>Desde PHP 5.1.0</h1>  
		 * @throws DOMBasicAttribReadOnlyException If 'Read Only' ON.
		 * @throws DOMBasicAttribNotFoundException
		 *         If $attrib is not a key in the $_attribs array.
		 * @param string $attrib The name of the attrib to unset.
		 */
		public function __unset($attrib) {
			//echo "Eliminando '$attrib'\n";
			try{
				self::tryingWrite($attrib);
				/*
					if(in_array($attrib,$this->_attribs)){
					$index=array_search($child, $this->_attribs);
					unset($this->_attribs[$index]);
				}
				 */
				unset($this->_attribs[$attrib]);
			}catch(Exception $e){
				self::writeLog($e->getMessage(), $e->getTrace());
			}
		}
		//---------------- END: MAGICS METHODS --------------------
		
		//---------------- BEGIN: ABSTRACT METHODS INTERFAZ ARRAY-ACCESS -----------------
		/**
		 * Returns if an attrib exists.
		 * Allows isset() using ArrayAccess.
		 *
		 * @param string $attrib The name of the attrib to get.
		 * @return bool Whether the attrib exists.
		 */
		public function offsetExists( $attrib )	{
			return $this->__isset( $attrib );
		}
		/**
		 * Returns an attrib value.
		 * Get an attrib value by ArrayAccess.
		 *
		 * @throws DOMBasicAttribNotFoundException
		 *         If $attrib is not a key in the $_attribs array.
		 * @param string $attrib The name of the attrib to get.
		 * @return mixed The attrib value.
		 */
		public function offsetGet( $attrib ) {
			return $this->__get( $attrib );
		}
		
		/**
		 * Set an attrib.
		 * Sets an attrib using ArrayAccess.
		 *
		 * @throws DOMBasicAttribNotFoundException
		 *         If $attrib is not a key in the $_attribs array.
		 * @throws DOMBasicValueException
		 *         If the value for a attrib is out of range.
		 * @param string $attrib The name of the attrib to set.
		 * @param mixed $attrib The value for the attrib.
		 * @return DOM_element $this este elemento (DOM).
		 */
		public function offsetSet( $attrib, $value ) {
			try{
				self::tryingWrite($attrib);
				$this->__set( $attrib, $value );
			}catch(Exception $e){
				self::writeLog($e->getMessage(), $e->getTrace());
			}
			return $this;
		}
		
		/**
		 * Unset an attrib.
		 * Unsets an attrib using ArrayAccess.
		 *
		 * @throws DOMBasicAttribNotFoundException
		 *         If $attrib is not a key in the $_attribs array.
		 * @throws DOMBasicValueException
		 *         If the value for a attrib is out of range.
		 * @param string $attrib The name of the option to unset.
		 */
		public function offsetUnset( $attrib ) {
			try{
				self::tryingWrite($attrib);
				$this->__set( $attrib, null );
			}catch(Exception $e){
				self::writeLog($e->getMessage(), $e->getTrace());
			}
		}
		//---------------- END: ABSTRACT METHODS INTERFAZ ARRAY-ACCESS --------------
		
		//---------------- BEGIN: ABSTRACT METHODS INTERFAZ ITERATOR-AGGREGATE --------------
		public function getIterator() {
			return new ArrayIterator($this->_attribs);
		}
		//---------------- END: ABSTRACT METHODS INTERFAZ ITERATOR-AGGREGATE --------------
		
		//---------------- BEGIN: ATTRIBS HANDLER (TAMBIEN __set() DE LOS METODOS MAGICOS) ---------------
		/**
		 * <p>El parametro sera un array asociativo de atributos con pares correctos 'clave=valor'.</p>
		 * <p>El programador debe asegurarse que son nombres estandarizados para los atributos de elementos DOM.(W3C)</p>
		 * <p><span title="Filtrado futuro." style="color:navy; background:yellow;">TODO</span>: FILTRADO: 
		 * <del>Solo se admitiran nombres estandarizados para los atributos de elementos DOM.(W3C)</del></p> 
		 * @throws DOMBasicAttribNotFoundException
		 *         If $attrib is not a key in the $_attribs array.
		 * @throws DOMBasicValueException
		 *         If the value for a attrib is out of range.
		 * @param array $asocArrayAttribs The array of the attribs to set.
		 * @return DOM_element $this este elemento (DOM).
		 **/
		public function setAttribs($asocArrayAttribs){
			try{
				self::tryingWrite($asocArrayAttribs);
				if(!is_null($asocArrayAttribs) && is_array( $asocArrayAttribs) ) $this->_attribs=$asocArrayAttribs;
			}catch(Exception $e){
				self::writeLog($e->getMessage(), $e->getTrace());
			}
			return $this;
		}
		/**
		 * <p>Retorna todos los atributos establecidos como un array asociativo 'clave=valor'.</p>
		 * @return array assoc attribs (key=value) or null if not defined.
		 **/
		public function getAttribs(){
			return $this->_attribs;
		}
		/**
		 * <p>Retorna todos los atributos establecidos como una cadena con los pares 'clave=valor' separados por espacios.</p>
		 * <p>Si el atributo comienza con la palabra reservada '_null' entonces solo imprimira el valor entrecomillado, por el 
		 * contrario si el valor es 'nulo' entonces solo imprimira la clave (sin comillas).</p>
		 * <p>Este metodo esta pensado para poder retornar atributos de etiquetas XHTML (y XML), donde existen casos de atributos 
		 * sin valor y otros de atributos sin clave (por ej. en la etiqueta 'DOCTYPE')</p>
		 * <p>Es sinonimo de '__toString()'.</p>
		 * <p style="background:yellow; color:navy;">OJO !!: Que sea sinonimo no significa que pueda llamarse dentro de esta 
		 * funcion a '__toString()' ya que crearia una REFERENCIA CIRCULAR!..</p>;
		 * @return string Cadena de pares 'attrib="attribValue"' separados por espacios
		 **/
		public function getAttribsStr() {
			//return $this->__toString();
			if(is_null($this->_attribs)) return "";
			$cadAttribs="";
			foreach($this->_attribs as $clave=>$valor) {
				//echo "toString de attribs2";
				//SIN CLAVE (CLAVE NUMERICA), se entiende entregar unicamente el $valor entrecomillado (por ej. DOCTYPE) 
				if( substr($clave, 0, 5)=="_null" ){
					$cadAttribs .= '"'.$valor.'" ';
				}//SIN VALOR (VALOR NULO), se entiende entrega unicamente la clave (para atributos unicos como 'selected', 'checked', ..)
				elseif(is_null($valor)){
					$cadAttribs .= $clave.' ';
				}else {
					$cadAttribs .= $clave.'="'.$valor.'" ';
				}
			}
			//$linksHTML[]='<a'.$clase.$id.$name.' href="'.$valor.'"'. ($widthTitle ? (' title="'.$clave.'"') : '') .'>'.$clave.'</a>';
			$cadAttribs = ($cadAttribs?(" ".trim($cadAttribs)):"");
			return $cadAttribs;
		}
		/**
		 * <p>El programador debe asegurarse que los atributos aportados son nombres estandarizados y valores validos 
		 * para los atributos de elementos DOM.(W3C)</p>
		 * <p>Retorna <del>el total de los atributos establecidos si no hay exceptcion.</del> $this</p>
		 * <p><span title="Filtrado futuro." style="color:navy; background:yellow;">TODO</span>: FILTRADO:
		 * <del>Solo se admitiran nombres estandarizados para los atributos de elementos DOM. (W3C)</del></p> 
		 * @throws DOMBasicAttribNotFoundException
		 *         If $attrib is not a key in the $_attribs array.
		 * @throws DOMBasicValueException
		 *         If the value for a attrib is out of range.
		 * @param string $attrib The name of the attrib to add.
		 * @param mixed $valorAttrib The value of the attrib to add.
		 * @return DOM_element $this este elemento (DOM).
		 **/
		public function addAttrib($attrib, $valorAttrib){
			try{
				self::tryingWrite($attrib);
				if(is_null($this->_attribs)) $this->_attribs=array();
				if(!is_null($attrib)){
					$this->_attribs[$attrib]=$valorAttrib;
				}
				//return count($this->_attribs);
			}catch(Exception $e){
				self::writeLog($e->getMessage(), $e->getTrace());
			}
			//return array_push ( $this->_links, $array);
			//return array_push ( $this->_links, new Object($nombreLink => $direccionLink));
			return $this;
		}
		/**
		 * <p>Añade atributos (si no existian previamente). El parametro sera un array asociativo de atributos con pares correctos 'clave=valor'.</p>
		 * <p>Retorna <del>el total de los atributos establecidos.</del> $this</p>
		 * <p>El programador debe asegurarse que son nombres estandarizados (y valores validos) para los atributos de elementos DOM.(W3C)</p>
		 * <p><span title="Filtrado futuro." style="color:navy; background:yellow;">TODO</span>: FILTRADO:
		 * <del>Solo se admitiran nombres estandarizados para los atributos de elementos DOM. (W3C)</del></p> 
		 * @throws DOMBasicAttribNotFoundException
		 *         If $attrib is not a key in the $_attribs array.
		 * @throws DOMBasicValueException
		 *         If the value for a attrib is out of range.
		 * @param array $arrayAttribs The array of the attribs to add.
		 * @return DOM_element $this este elemento (DOM).
		 **/
		public function addAttribs($arrayAttribs){
			try{
				self::tryingWrite($arrayAttribs);
				foreach($arrayAttribs as $clave=>$valor) {
					$this->_attribs[$clave]=$valor;
				}
				//return count($this->_attribs);
			}catch(Exception $e){
				self::writeLog($e->getMessage(), $e->getTrace());
			}
			return $this;
		}
		/**
		 * <p>Suprime o elimina el atributo indicado (si es que existe). Retorna <del>el numero de atributos que quedan.</del> $this</p>
		 * @throws DOMBasicAttribNotFoundException
		 *         If $attrib is not a key in the $_attribs array.
		 * @throws DOMBasicValueException
		 *         If the value for a attrib is out of range.
		 * @param string $attrib The name of the attrib to remove.
		 * @return DOM_element $this este elemento (DOM).
		 **/
		public function removeAttrib($attrib){
			try{
				self::tryingWrite($attrib);
				if(is_null($this->_attribs)) $this->_attribs=array();
				unset($this->_attribs[$attrib]);
				//return count($this->_attribs);
			}catch(Exception $e){
				self::writeLog($e->getMessage(), $e->getTrace());
			}
			return $this;
		}
		/**
		 * <p>Suprime o elimina todos los atributos indicados (si es que existen). Retorna <del>el numero de atributos que quedan.</del> $this</p>
		 * @throws DOMBasicAttribNotFoundException
		 *         If $attrib is not a key in the $_attribs array.
		 * @throws DOMBasicValueException
		 *         If the value for a attrib is out of range.
		 * @param array string $arrayAttribs Array with the attribs's name to remove.
		 * @return DOM_element $this este elemento (DOM).
		 **/
		public function removeAttribs($arrayAttribs){
			try{
				self::tryingWrite($arrayAttribs);
				foreach($arrayAttribs as $attrib) {
					unset($this->_attribs[$attrib]);
				}
				//return count($this->_attribs);
			}catch(Exception $e){
				self::writeLog($e->getMessage(), $e->getTrace());
			}
			return $this;
		}
		/**
		 * <p>Suprime o elimina todos los atributos. Retorna <del>el numero de atributos que quedan.</del> $this</p>
		 * @throws DOMBasicAttribNotFoundException
		 *         If $attrib is not a key in the $_attribs array.
		 * @throws DOMBasicValueException
		 *         If the value for a attrib is out of range.
		 * @return DOM_element $this este elemento (DOM).
		 **/
		public function clearAttribs(){
			try{
				self::tryingWrite($arrayAttribs);
				$this->_attribs=array();
				//return count($this->_attribs);
			}catch(Exception $e){
				self::writeLog($e->getMessage(), $e->getTrace());
			}
			return $this;
		}
		/**
		 * <p>Retorna el total de los atribuos establecidos.</p>
		 * @return int Total de atributos establecidos
		 **/
		public function countAttrs(){
			if(is_null($this->_attribs)) $this->_attribs=array();
			return count($this->_attribs);
		}
		//---------------- END: ATTRIBS HANDLER ---------------------------
		
		/** 
		 * <p>Compara si otro objeto es igual a este (no si es el mismo); para esto se tienen que cumplir las siguientes normas: </p>
		 * <ul>
		 * 	<li>Que los dos sean instancias de la misma Clase (DOM_attribs).</li>
		 * 	<li>Que los dos tengan definidos el mismo numero de atributos y con los mismos valores.</li>
		 * </ul>
		 * @param DOM_attribs $objAttribs Algun objeto instancia de esta Clase
		 * @return boolean **/
		public function equals($objAttribs) {
			if(is_null($objAttribs)) return false;
			if(is_null($objAttribs->_attribs)) $objAttribs->_attribs=array();
			if(is_null($this->_attribs)) $this->_attribs=array();
			//1º COMPARACION SI ES UNA INSTACIA DE ESTA CLASE
			if( !($objAttribs instanceof $this) ) return false;	//is_a(), get_class();
			//if(! is_subclass_of($objAttribs, self::TAG, false) ) return false;
			//2º COMPARACION RAPIDA
			$equal =( count($objAttribs->_attribs) == count($this->_attribs) );
			//3º COMPARACION ATRIBUTO A ATRIBUTO
			if($equal){
				$contador=0;
				foreach($objAttribs->_attribs as $clave=>$valor) {
					foreach($this->_attribs as $clave2=>$valor2) {
						if(($clave==$clave2) && ($valor==$valor2)) $contador++;
					}
				}
				$equal = ( (count($this->_attribs) == $contador) && (count($objAttribs->_attribs) == $contador) );
			}
			return $equal;
		}
		
		public function __toString() {
			if(is_null($this->_attribs)) return "";
			$cadAttribs="";
			foreach($this->_attribs as $clave=>$valor) {
				//echo "toString de attribs2";
				$cadAttribs .= $clave.'="'.$valor.'" ';
			}
			//$linksHTML[]='<a'.$clase.$id.$name.' href="'.$valor.'"'. ($widthTitle ? (' title="'.$clave.'"') : '') .'>'.$clave.'</a>';
			$cadAttribs = ($cadAttribs?(" ".trim($cadAttribs)):"");
			return $cadAttribs;
		}
		
		/** 
		 * <p>Retorna una cadena con el formato de las URL's, construida con los Atributos de este Objeto.<br />
		 * Contiene un parametro $encode indicando el tipo de codificacion a aplicar: 'RFC_1738' (espacios=+) o 'RFC_3986' (espacions=%20),
		 * las cuales estan implementadas como cadenas staticas de esta clase.</p>
		 * @param $encode Cadena indicando el tipo de codificacion (alguna de las dos constantes de esta
		 * clase {@link DOM_attribs->ENCODE_RFC_1738 RFC_1738} o {@link DOM_attribs#ENCODE_RFC_3986 RFC_3986}).
		 * @return Cadena con formato de codificacion URL. 
		 **/
		protected function toURL($encode = self::ENCODE_RFC_3986) {
			$numericPrefix="var";	//en caso de arrays numericos
			$argSep="&";
			//$this->addAttrib("delete", "%20+-_?¿^*[]¨{}.:,;&");
			$attribsURL = http_build_query($this->_attribs, $numericPrefix, $argSep);
			//para evitar variables array ... files[]=1&files[]=2& ... sin numeracion hacer lo siguiente:
			//preg_replace('/%5B[0-9]+%5D/simU', '%5B%5D', $query);
			//$attribsURL = urlencode($attribsURL);
			//$attribsURL = urldecode($attribsURL);
			//var_dump($attribsURL);
			//$attribsURL = rawurlencode($attribsURL);
			return $attribsURL;
		}
		/**
		 * <p>Establece y retorna un array de atributos con sus correspondientes valores extraidos de una cadena con el formato de las URL's, 
		 * para construir Atributos de este Objeto.</p>
		 * <p>El parametro es la cadena desde la que se extraeran los atributos y sus valores, esta cadena tendra el formato de las URL's 
		 * (relativa o absoluta) donde debe incluirsele una 'queryString' (entre '?' y '#'), Igual a la generada por el metodo toURL().</p>
		 * @param $strURLquery Cadena desde la que se extraeran los atributos y sus valores, esta cadena tendra el formato entregado en
		 * las URL's como parte de su 'queryString' (entre '?' y '#').
		 * @return Array de atributos extraidos de la queryString.
		 **/
		protected function fromURL($strURLquery) {
			$attribsURL = self::arrayFromURL($strURLquery);
			//var_dump($attribsURL);
			$this->setAttribs($attribsURL);
			return $attribsURL;
		}
		/**
		 * <p>Retorna un array de atributos con sus correspondientes valores extraidos de una cadena con el formato de las URL's.</p>
		 * <p>El parametro es la cadena desde la que se extraeran los atributos y sus valores, esta cadena tendra el formato de las URL's 
		 * (relativa o absoluta) donde debe incluirsele una 'queryString' (entre '?' y '#'), Igual a la generada por el metodo toURL().</p>
		 * @param $strURLquery Cadena desde la que se extraeran los atributos y sus valores, esta cadena tendra el formato entregado en
		 * las URL's como parte de su 'queryString' (entre '?' y '#').
		 * @return Array de atributos extraidos de la queryString.
		 **/
		public static function arrayFromURL($strURLquery) {
			//$strURLquery ="scheme://user:pass@host.com:port/path?".$strURLquery."#fragment/anchor";
			
			//
			$attribsURL = parse_url($strURLquery);
			if( ! array_key_exists("path",$attribsURL) ){
				$attribsURL = parse_url("path.php?" . $strURLquery);
			}
			if( ! array_key_exists("host",$attribsURL) ){
				$attribsURL = parse_url("www.host.com/" . $strURLquery);
			}
			if( ! array_key_exists("scheme",$attribsURL) ){
				$attribsURL = parse_url("http://" . $strURLquery);
			}
			/*
			echo "<pre>";
			print_r($attribsURL);
			echo "</pre>";
			*/
			$attribsURL_str = urldecode( $attribsURL['query'] );
			parse_str($attribsURL_str, $attribsURL);
			//var_dump($attribsURL);
			return $attribsURL;
		}
		//---------------- FIN LINKS ----------------
		
		//----------------  BEGIN: JSON  ----------------------------
		/**
		 * <p>Metodo para retornar la cadena JSON que representa estos atributos en la forma '{"clave1":"valor1", "clave2":"valor2"}'.</p>
		 * <p>Aporta un segundo parametro para codificar todos los valores (no las claves) en 'base64', (DEFECTO=true),
		 * asi podriamos evitar el problema de los tipos de codificacion empleados (JSON solo admite UTF-8).</p>
		 * <p>NO UTILIZA LA FUNCION PHP 'json_encode(..)'</p>
		 * <p><del>Utiliza las siguientes constantes PHP 5.3: JSON_HEX_QUOT && JSON_HEX_TAG && JSON_HEX_AMP && JSON_HEX_APOS</del></p>
		 * @param boolean $return Indica si retornar el resultado (TRUE) o imprimirlo (FALSE).
		 * @param boolean $base64values Indica si codificar los textos en 'base64' o no.
		 * @return String JSON de estos atributos o NULL en caso de desear imprimirlo.
		 **/
		public function toJSON($return=true, $base64values=true) {
			//return json_encode($this->toHTML(), JSON_HEX_QUOT && JSON_HEX_TAG && JSON_HEX_AMP && JSON_HEX_APOS);
			$array=array();
			foreach ($this->getAttribs() as $clave=>$valor){
				$clave = addslashes( htmlspecialchars( utf8_encode($clave) ) );
				$valor = addslashes( htmlspecialchars( utf8_encode($valor) ) );
				$clave=self::filtrarStrJSON($clave);
				$valor=self::filtrarStrJSON($valor);
				if($base64values) {
					$array[]='"'.$clave.'":"'.base64_encode($valor).'"';
				}else{
					$array[]='"'.$clave.'":"'.$valor.'"';
				}
			}
			//$return = '"'.__CLASS__.'-STATIC":{'.implode(',', $array).'}';
			$result = '{'.implode(',', $array).'}';
			if ($return) {
				return $result;
			} else {
				print $result;
				return null;
			}
		}
		
		public function fromJSON($arrJSON) {
			self::clearAttribs();
			$arrAttribs=array();
			foreach ($arrJSON as $clave=>$valor){
				if(is_object($valor)){
					foreach ($valor as $key=>$value){
						$arrAttribs[$key]=$valor;
					}
				}
			}
			self::setAttribs($arrAttribs);
			return $this;
		}

		/** Limpia una cadena de RETORNOS DE CARRO, AVANCES DE LINEA y TABULACIONES, preparandola asi para datos JSON **/
		public static function filtrarStrJSON($str=""){
			/*
			 $str = str_replace('\t', '', $str);
			$str = str_replace('\n', '', $str);
			$str = str_replace('\r', '', $str);
			*/
			//$str = strtr($str, '\r\n\t', '');//array('\r','\n','\t'), array('','','')
			$str = strtr($str, array("\r"=>'',"\n"=>'',"\t"=>''));
			return $str;
		}
		//----------------  END: JSON  ------------------------------
		
		//METODO PARA MENSAJEAR AL LOG
		public static function writeLog($mensaje, $trace){
			echo '<pre class="doom-exception" style="background:pink; font-size:x-small;">';
			echo "<h2>EXCEPTION:</h2><ul><code>";
			echo "<li>MENSAJE: ".$mensaje."</li><li>TRACE: ";
			print_r($trace);
			echo "</li></code></ul></pre>";
		}
		//METODO PARA INSERTAR DATOS DE EJEMPLO
		public function setEjemplo(){
			$this->_data=array("attr_1"=>"valor del atributo 1", "attr_2"=>"valor del atributo 2");
		}
	}
?>