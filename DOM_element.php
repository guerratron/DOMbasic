<?php
//PUNTO DE ENTRADA DE TODOS LOS ELEMENTOS DEL DOM CREADOS:
//CONSTANTES A TRAVES DE INI [solo deben conocerse ruta al ini y nombre de la seccion del ini para las constantes]
$config = parse_ini_file('config.ini');	//RUTA AL ARCHIVO INI DE CONFIGURACION
$seccConsts = $config['_SECC_CONSTS_INI_DOM'];	//SECCION DEL INI DONDE SE ENCUENTRAN LAS CONSTANTES
//echo '<div style="background:green;">'.$seccConsts.'</div>';
$config = parse_ini_file('config.ini', true);	//AHORA POR SECCIONES
//ESTABLECIENDO LAS CONSTANTES DEL PAKETE
foreach($config as $key => $value) {
	if($key==$seccConsts){
		foreach($value as $k => $v) {
			//echo "[".$seccConsts."] ".$k." = ".$v."<br />";
			if(! defined($k)) define($k, $v);
		}
	}
}
if(! defined('QUOTE')) define('QUOTE', '"');	//Permite utilizar " en el archivo ini mediante QUOTE
if(! defined("_PATH_CLASS_DOM_")) define("_PATH_CLASS_DOM_", realpath( dirname(__FILE__) ));//"."
/*
//TODO: BORRAR: LAS SIGUIENTES DEFINICIONES SE MANTIENEN POR COMODIDAD EN EL DESARROLLO CON ECLIPSE
if(! defined("_PATH_EXCEPTION_DOM_")) define("_PATH_EXCEPTION_DOM_", "/exceptions");
if(! defined("_PATH_UTIL_DOM_")) define("_PATH_UTIL_DOM_", "/util");
if(! defined("_CONF_INI_FILE_DOM_")) define("_CONF_INI_FILE_DOM_", "config.ini");
if(! defined("_SECC_CONF_INI_DOM")) define("_SECC_CONF_INI_DOM", "[CONF_SECC]");
if(! defined('QUOTE')) define('QUOTE', '"');	//Permite utilizar " en el archivo ini mediante QUOTE
*/

	//define("TAG", "LinkClass");
// we've writen this code where we need
function __autoload($classname) {
	$ruta=_PATH_CLASS_DOM_;
	if(substr($classname, -9)=="Exception") $ruta .= _PATH_EXCEPTION_DOM_;
	//if(substr($classname, -9)=="Configuration") $ruta .= "/conf";
	if(substr($classname, 3)=="INI") $ruta .= _PATH_UTIL_DOM_;
	$filename = $ruta."/". $classname .".php";
	try{
		include_once($filename);
		//parent::__autoload($classname);
	} catch (Exception $e){
		throw new Exception("Imposible cargar $classname desde el directorio $ruta. ERROR: ".$e->getMessage().PHP_EOL);
	}
}
	/**
	 * Clase padre para crear cualquier elemento del DOM. Admite CONCATENACION DE METODOS mediante el retorno de la construccion '$this'
	 * en todos los metodos 'NO-GETTER': &hellip; <code>$this->setText('text')->removeChild($child)->importConfINI();</code> &hellip;
	 **/
	class DOM_element extends DOM_attribs implements DOM_Interface {
		/**
		 * <h1>Name Class</h1>
		 * Constante de cadena que representa el nombre de esta Clase, util para labores de Depuracion 
		 * (agregandola a las sentencias del log o de trade...)
		 * @var String constant
		 * @access public
		 */
		const N_C = __CLASS__;
		
		//------------  BEGIN: CONFIGURACION  -----------------
		/**
		 * ¿ Permitir el patron SINGLETON ?
		 **/
		const PATRON_SINGLETON=true;
		/**
		 * <h1>Boolean indicando si los atributos de este elemento son DE SOLO LECTURA O ESCRIBIBLES.</h1>
		 * @var String
		 * @access protected
		 */
		protected $_READ_ONLY=false;//=boolean;

		/**
		 * Variable de cadena indicando la etiqueta DOM (HTML) de este elemento
		 * @var String
		 * @access protected
		 */
		protected $TAG = "";
		/**
		 * Variable de cadena indicando el tipo DOM de este elemento
		 * @var String
		 * @access protected
		 */
		protected $TYPE = "container";
		/**
		 * Variable de cadena indicando la descripcion de este elemento
		 * @var String
		 * @access protected
		 */
		protected $DESC = "DOM's container element";
		//CONSTANTES QUE REPRESENTAN LAS APERTURA Y CIERRE DE ETIQUETAS DE LOS ELEMENTOS DOM.
		//Algunos elementos autocontendidos (como '<img />') pueden modificarlas, o incluso anularlas (como 'textNode')
		/**
		 * Variable de cadena indicando la apertura de la etiqueta HTML de este elemento
		 * <p style="background:yellow; color: navy">Algunos elementos autocontendidos (como '&lt;img />')
		 * pueden modificarlas, o incluso anularlas (como 'textNode')</p>
		 * @var String
		 * @access protected
		 */
		protected $OPEN_TAG_LEFT="<";
		/**
		 * Variable de cadena indicando el cierre de la etiqueta HTML de apertura de este elemento
		 * <p style="background:yellow; color: navy">Algunos elementos autocontendidos (como '&lt;img />')
		 * pueden modificarlas, o incluso anularlas (como 'textNode')</p>
		 * @var String
		 * @access protected
		 */
		protected $OPEN_TAG_RIGHT=">";
		/**
		 * Variable de cadena indicando la apertura de la etiqueta HTML de cierre de este elemento
		 * <p style="background:yellow; color: navy">Algunos elementos autocontendidos (como '&lt;img />')
		 * pueden modificarlas, o incluso anularlas (como 'textNode')</p>
		 * @var String
		 * @access protected
		 */
		protected $CLOSE_TAG_LEFT="</";
		/**
		 * Variable de cadena indicando el cierre de la etiqueta HTML de este elemento
		 * <p style="background:yellow; color: navy">Algunos elementos autocontendidos (como '&lt;img />')
		 * pueden modificarlas, o incluso anularlas (como 'textNode')</p>
		 * @var String
		 * @access protected
		 */
		protected $CLOSE_TAG_RIGHT=">";

		//---- BEGIN: AVISOS ------
		/**
		 * ¿ Lanzar Aviso cuando se intenta tomar una instancia estatica mediante el 'Patron SINGLETON' sin estar permitida por
		 * '<a href="DOM_attribs::PATRON_SINGLETON" title="PATRON_SINGLETON">'PATRON SINGLETON'</a> ?
		 **/
		const AVISO_SINGLETON=true;
		/**
		 * ¿ Lanzar Aviso cuando se lee un atributo que no existe ?
		 **/
		protected $AVISO_GET=false;
		//---- END: AVISOS ------
		

		/*
		protected static final $DTD_DOCTYPE_HTML=0;
		protected static final $DTD_DOCTYPE_XHTML_TRANSITIONAL=10;
		protected static final $DTD_DOCTYPE_XHTML_STRICT=10;
		protected static final $DTD_XML_1_0=20;*/
		protected static $DTD_DOCTYPE_HTML=0;
		protected static $DTD_DOCTYPE_XHTML_TRANSITIONAL=10;
		protected static $DTD_DOCTYPE_XHTML_STRICT=10;
		protected static $DTD_XML_1_0=20;
		protected static $LINE_BREAK="\n";
		//------------ END: CONFIGURACION ------------------------
		
		/**
		 * Clave de este elemento
		 * @var String
		 * @access protected
		 */
		protected $_key="";
		/**
		 * Texto que contiene este elemento.
		 * @var String
		 * @access protected
		 */
		protected $_text="";
		/**
		 * Array de elementos del DOM hijos de este
		 * @var Array DOM_element
		 * @access protected
		 */
		protected $_children=array();

		//---------------------  BEGIN: PATRON SINGLETON  -------------------
		/**
		 * PATRON ESTATICO SINGLETON
		 * @var DOM_attribs
		 * @access protected
		 */
		protected static $instance;
		/**
		 * PATRON SINGLETON. Tomar una instancia de forma estatica.<br />
		 * $attrbs = DOM_attribs::getInstance();
		 **/
		public static function getInstance() {
			if(self::PATRON_SINGLETON){
					//if (!isset(self::$instance)) {
					if (is_null(self::$instance)) {
						$c = __CLASS__;	//self::TAG
						//$instance = new $c;
						self::$instance = new $c();
					}
					return self::$instance;
			}else{
				try {
					if(self::AVISO_SINGLETON) throw new DOMBasicSingletonException();
				}catch (Exception $e){
					self::writeLog($e->getMessage(), $e->getTrace());
				}
			}
		}
		private function setInstance() {
			try{	
					$this->tryingWrite("INSTANCE");
					self::$instance=$this;
			 }catch(Exception $e){
			 		$this::writeLog($e->getMessage(), $e->getTrace());
			 }
		}
		//----------------------  END: PATRON SINGLETON  --------------------

		//----------------------  BEGIN: MAGICS METHODS  --------------------
			//CONSTRUCTOR
		public function __construct($key=null){
			if($key != null) $this->_key=$key;
			$this->importConfINI();
			$this->reinicializar();
			$this::$instance=$this;
			//return $this;
		}
			//DESTRUCTOR
		public function __destruct(){
			parent::__destruct();
			//echo "<h1>DESTRUYENDO ".$this->getKey()."</h1>";
			$this::$instance=null;
			$this->_children=null;
		}
			//CLONE
		public function __clone(){
			//return self::getInstance();
			$clase=__CLASS__;	//self::TAG;
			$clon=new $clase($this->_key);
			$clon->setReadOnly(false);
			$clon->setChildren($this->_children);
			$clon->setAttribs($this->getAttribs());
			$clon->setConfiguration($this->getConfiguration());
			$clon->setReadOnly($this->getReadOnly());
			return $clon;	//DA ERRORES EN PHP 4.0
		}
			//UNSET
		/**
		 * <h1>Desde PHP 5.1.0</h1>
		 * @throws DOMBasicElementReadOnlyException If 'Read Only' ON.
		 * @throws DOMBasicElementNotFoundException
		 *         If $attrib is not a key in the $_attribs array.
		 * @param DOM_element $child The element to unset.
		 */
		public function __unset($child) {
			//echo "Eliminando '$child'\n";
			try{
				$this->tryingWrite($child);
				if(in_array($child,$this->_children)){
					$index=array_search($child, $this->_children);
					unset($this->_children[$index]);
				}
			}catch(Exception $e){
				$this->writeLog($e->getMessage(), $e->getTrace());
			}
		}

		public function __toString() {
			//return $this->_text;
			return $this->getOpenTag() . $this->_text . $this->getCloseTag();
		}
		
		/*
		 public static function __set_state($an_array) // A partir de PHP 5.1.0
		{
		$obj = new self($an_array['_key']);
		$obj->setReadOnly($an_array['_READ_ONLY']);
		$obj->setTag($an_array['TAG']+"_22");
		$obj->TYPE = $an_array['TYPE'];
		$obj->DESC = $an_array['DESC'];
		$obj->OPEN_TAG_LEFT = $an_array['OPEN_TAG_LEFT'];
		$obj->OPEN_TAG_RIGHT = $an_array['OPEN_TAG_RIGHT'];
		$obj->CLOSE_TAG_LEFT = $an_array['CLOSE_TAG_LEFT'];
		$obj->CLOSE_TAG_RIGHT = $an_array['CLOSE_TAG_RIGHT'];
		$obj->AVISO_GET = $an_array['AVISO_GET'];
		//$obj->_key = $an_array['_key'];
		$obj->setText( $an_array['_text'] );
		$obj->_children = $an_array['_children'];
		
		return $obj;
		}
		*/
		//-----------------  END: MAGICS METHODS  -----------------------------
		
		//-----------------  BEGIN: ABSTRACT METHODS IN PARENT  ----------------
		public function reinicializar(){
			//$this->_attribs=array();
			try{
				$this->tryingWrite("[".$this->_key."]".$this->TAG);
				$this->_children=array();
			}catch(Exception $e){
				$this->writeLog($e->getMessage(), $e->getTrace());
			}
			//TODO: ¡¡OJO NO ACTIVAR!! PUEDE PROVOCAR UNA EXCEPCION AL SER LLAMADA DESDE UN CONSTRUCTOR.
			//register_shutdown_function(array($this, '__destruct'));	//para evitar un bug en PHP 5.3.10 con la destruccion de objetos
			return $this;
		}
		//ABSTRACT METHOD IN PARENT
		public function setReadOnly($readOnly){
			$this->_READ_ONLY=$readOnly;
			return $this;
		}
		public function getReadOnly(){
			return $this->_READ_ONLY;
			return $this;
		}
						//------------ OVERRIDE  -------------
		/**
		 * <p><b>:OVERRIDE-PARENT:</b></p>
		 * <p>Notifica una accion de escritura al objeto; Si es de solo-lectura lanzara una Excepcion.</p>
		 * @return boolean TRUE=OK, FALSE=throw DOMBasicElementReadOnlyException()
		 * @throws DOMBasicElementReadOnlyException;
		 **/
		protected function tryingWrite($arg="") {
			//parent::tryingWrite($arg);
			if($this->_READ_ONLY){
				//$mensaje="Intentando escribir en un Objeto de Solo-Lectura!!";
				throw new DOMBasicElementReadOnlyException($arg, DOMBasicElementReadOnlyException::READ);
				return false;
			}
			return true;
		}
		//-----------------  END: ABSTRACT METHODS IN PARENT  ----------------
		
		//-----------------  BEGIN: GETTER & SETTER  -------------------------
		public function setKey(string $key=null){
			try{
				$this->tryingWrite("[".$this->_key."]".$this->TAG);
				if(! is_null($key))$this->_key=$key;
			}catch(Exception $e){
				$this->writeLog($e->getMessage(), $e->getTrace());
			}
			return $this;
		}
		public function getKey(){
			return $this->_key;
		}
		public function getTag(){
			return $this->TAG;
		}
		public function setTag($tag){
			$this->TAG=$tag;
			return $this;
		}
		public function getOpenTag(){
			return ($this->OPEN_TAG_LEFT . $this->TAG . parent::getAttribsStr() . $this->OPEN_TAG_RIGHT);
		}
		public function getCloseTag(){
			if(strlen( $this->CLOSE_TAG_LEFT . $this->CLOSE_TAG_RIGHT ) == 0){
				return "";
			}else{
				return ($this->CLOSE_TAG_LEFT . $this->TAG . $this->CLOSE_TAG_RIGHT);
			}
		}
		public function getType(){
			return $this->TYPE;
		}
		public function getDesc(){
			return $this->DESC;
		}
		//--------------------  END: GETTER & SETTER  -------------
		
		//--------------------  BEGIN: TEXT  ----------------------
		public function clearText(){
			//$textoAnterior="";
			try{
				$this->tryingWrite("[".$this->_key."]".$this->TAG);
				$textoAnterior=$this->getText();
				$objTxt=new DOM_textNode();
				$this->removeChildrenByType($objTxt->getType(), false);
			}catch(Exception $e){
				$this->writeLog($e->getMessage(), $e->getTrace());
			}
			//return $textoAnterior;
			return $this;
		}
		
		/**
		 * Agreaga un hijo de texto (textNode) a este elemento DOM, eliminando los hijos tipo 'textNode' que tubiese
		 * @param string $text para este elemento.
		 * @return string con el texto anterior.
		 **/
		public function setText($text){
			//$textoAnterior=$this->getText();
			try{
				//$this->tryingWrite("[".$this->_key."]".$this->TAG);
				$this->clearText();
				//$this->_text=$text;
				$txt=new DOM_textNode();
				$txt->setText($text);
				$this->addChild($txt);
			}catch(Exception $e){
				$this->writeLog($e->getMessage(), $e->getTrace());
			}
			//return $textoAnterior;
			return $this;
		}
		
		public function addText($text){
			try{
				$this->tryingWrite("[".$this->_key."]".$this->TAG);
				$txt=new DOM_textNode();
				$txt->setText($text);
				$this->addChild($txt);
			}catch(Exception $e){
				$this->writeLog($e->getMessage(), $e->getTrace());
			}
			return $this;
		}
		
		/** Retorna todo el texto encontrado en este elemento y en sus hijos. 
		 * @param $filter [boolean] Permite especificar si el texto se retorna filtrado mediante 'htmlspecialchars_decode(...)' y 
		 * 'stripcslashes(...)' o no. [Por defecto NO] 
		 * @return string con el texto de todos los nodos tipo 'textNode' de este elemento y sus hijos. 
		 **/
		public function getTextAll($filter=false){
			$texto = $filter ? htmlspecialchars_decode(stripslashes( $this->_text )) : $this->_text;
			if( is_null($this->getChildren()) )	return $texto;
			foreach ($this->getChildren() as $child){
					if( is_null($child) ) continue;
					$texto .= $filter ? htmlspecialchars_decode(stripslashes( $child->getText($filter) )) : $this->getText($filter);
			}
			return $texto;
		}
		/**
		 * Metodo para retornar el texto de este elemento DOM (la concatenacion de los textos de todos los elementos textNode).
		 * @param $filter [boolean] Permite especificar si el texto se retorna filtrado mediante 'htmlspecialchars_decode(...)' y 
		 * 'stripcslashes(...)' o no. [Por defecto NO]
		 * @return string con el texto de todos los nodos tipo 'textNode' de este elemento.
		 **/
		public function getText($filter=false){
			$texto = $filter ? htmlspecialchars_decode(stripslashes( $this->_text )) : $this->_text;
			if( is_null($this->getChildren()) )	return $texto;
			foreach ($this->getChildren() as $child){
				//echo "<div>".$child->TYPE."</div>";
					if( is_null($child) || ($child->TYPE != "textNode") ) continue;
					//$texto =" :: " . $child->TYPE ." :: ";
					$texto .= $filter ? htmlspecialchars_decode(stripslashes( $child->_text )) : $this->_text;
					//htmlspecialchars_decode(stripslashes( $child->getText($grandchildren) ));
			}
			return $texto;
		}
		//-----------------  END: TEXT  -----------------------
		
		//----------------- BEGIN: CHILDREN HANDLER  ----------
		public function addChild(DOM_element $child=null){
			try{
				$this->tryingWrite("[".$this->_key."]".$this->TAG);
				if(! is_null($child)){
					$this->_children[]=$child;
				}
			}catch(Exception $e){
				$this->writeLog($e->getMessage(), $e->getTrace());
			}
			//return count($this->_children);
			return $this;
		}
		
		public function addChildren(array $children=null){
			try{
				$this->tryingWrite("[".$this->_key."]".$this->TAG);
				if( is_null($this->_children) )	$this->_children=array();
				if(is_array($children)){
					foreach ($children as $child){
						$this->_children[]=$child;
					}
				}
			}catch(Exception $e){
				$this->writeLog($e->getMessage(), $e->getTrace());
			}
			//return count($this->_children);
			return $this;
		}
		
		public function setChildren(array $children=null){
			try{
				$this->tryingWrite("[".$this->_key."]".$this->TAG);
				$this->_children=$children;
			}catch(Exception $e){
				$this->writeLog($e->getMessage(), $e->getTrace());
			}
			return $this;
		}
		
				//CHILD's GETTER
		public function getChildren(){
			return $this->_children;
		}
		
		public function getChildrenAll(){
			$children = array();
			foreach ($this->getChildren() as $child){
				$children[]=$child;
				if( count($child->getChildren())>0 ) $children[]=$child->getChildrenAll();
			}
			return $children;
		}
		
		public function getChildByKey($key, $grandchildren=true){
			if( is_null($this->getChildren()) ) return null;
			foreach ($this->getChildren() as $child){
				if($child->getKey()==$key) return $child;
				if($grandchildren){
					$childOfChild = $child->getChildByKey($key);
					if( ! is_null($childOfChild) ) return $childOfChild;
				}
			}
			return null;
		}
		
		public function getChildrenByTag($tag, $grandchildren=true){
			$children = array();
			foreach ($this->getChildren() as $child){
				if($child->getTag()==$tag) $children[]= $child;
				if($grandchildren){
					$childrenOfChild = $child->getChildrenByTag($tag);
					if( ! is_null($childrenOfChild) ) {
						foreach ($childrenOfChild as $c){
							//echo "ENCONTRADO [".$c->getKey()."] EN [".$child->getKey()."]";
							$children[]= $c;
						}
					}
				}
			}
			return $children;
		}
		public function getChildrenByType($type, $grandchildren=true){
			$children = array();
			foreach ($this->getChildren() as $child){
				if($child->getType()==$type) $children[]= $child;
				if($grandchildren){
					$childrenOfChild = $child->getChildrenByType($type);
					if( ! is_null($childrenOfChild) ) {
						foreach ($childrenOfChild as $c){
							//echo "ENCONTRADO [".$c->getKey()."] EN [".$child->getKey()."]";
							$children[]= $c;
						}
					}
				}
			}
			return $children;
		}
			//CHILD's ERASER
		public function removeChild($child, $grandchildren=true){
			$exito=false;
			foreach ($this->getChildren() as $hijo){
				//if($hijo->equalsExacts($child)) {
				if($hijo->equals($child)) {
					$exito=true;
					$this->__unset($child);
				}else{	//RECURSIVIDAD
					if($grandchildren) $exito = $exito || $hijo->removeChild($child, $grandchildren);
				}
			}
			//return $exito;
			return $this;
		}
		
		public function removeChildrenAll(){
			//ELIMINAR TODOS
			foreach ($this->getChildren() as $child){
				$this->__unset($child);
			}
			return $this;
		}
		public function removeChildByKey($key, $grandchildren=true){
			$contador=0;
			foreach ($this->getChildren() as $child){
				if($child->getKey()==$key){
					$contador++;
					$this->__unset($child);
				}else{	//RECURSIVIDAD
					if($grandchildren) $contador +=$child->removeChildByKey($key, $grandchildren);
				}
			}
			//return $contador;
			return $this;
		}
		
		public function removeChildrenByTag($tag, $grandchildren=true){
			$contador=0;
			foreach ($this->getChildren() as $child){
				if($child->getTag()==$tag){
					$contador++;
					$this->__unset($child);
				}else{	//RECURSIVIDAD
					if($grandchildren) $contador +=$child->removeChildrenByTag($tag, $grandchildren);
				}
			}
			//return $contador;
			return $this;
		}
		
		public function removeChildrenByType($type, $grandchildren=true){
			$contador=0;
			foreach ($this->getChildren() as $child){
				if($child->getType()==$type){
					$contador++;
					$this->__unset($child);
				}else{	//RECURSIVIDAD
					if($grandchildren) $contador +=$child->removeChildrenByType($type, $grandchildren);
				}
			}
			//return $contador;
			return $this;
		}
		//----------------- END: CHILDREN HANDLER  ----------

		//----------------- BEGIN: COMPARATOR  --------------
		/** <p>Compara si otro objeto es igual (comparable no clonable) a este (no si es el mismo); para esto se tienen que cumplir las 
		 * siguientes normas: </p>
		 * <ul>
		 * 	<li>Que los dos sean instancias de la misma Clase (el mismo tipo de elemento y etiqueta).</li>
		 * 	<li>Que los dos tengan definidos el mismo numero de atributos y con los mismos valores.</li>
		 * 	<li>Que los dos tengan definidos el mismo numero de hijos y con los mismos valores.</li>
		 * 	<li>Tambien que los dos tengan definida la misma clave.</li>
		 *  <li>Incluso que los dos contengan el mismo texto como contenido.</li>
		 * </ul>
		 * @param DOM_element $objDOM Algun objeto instancia de esta Clase
		 * @return boolean **/
		public function equals($objDOM) {
			$equal=true;
			//1º COMPARACION SI NO ES NULO
			if(is_null($objDOM)) return false;
			//if(! parent::equals($objDOM->getDOM_attrib())) return false;
			if(is_null($objDOM->_children)) $objDOM->_children=array();
			if(is_null($this->_children)) $this->_children=array();
			//2º COMPARACION SI ES UNA INSTACIA DE ESTA CLASE
			if( !($objDOM instanceof $this) ) return false;	//is_a(), get_class();
			//if(! is_subclass_of($objAttribs, self::TAG, false) ) return false;
			//3º COMPARACION VARIABLES
			//if($equal) $equal = ($this->_key == $objDOM->_key); //SE ADMITE DISTINTA
			if($equal) $equal = ($this->TAG == $objDOM->TAG);
			//if($equal) $equal = $equal && ($this->DESC == $objDOM->DESC); //SE ADMITE DISTINTA
			if($equal) $equal = ($this->OPEN_TAG_LEFT == $objDOM->OPEN_TAG_LEFT);
			if($equal) $equal = ($this->OPEN_TAG_RIGHT == $objDOM->OPEN_TAG_RIGHT);
			if($equal) $equal = ($this->CLOSE_TAG_LEFT == $objDOM->CLOSE_TAG_LEFT);
			if($equal) $equal = ($this->CLOSE_TAG_RIGHT == $objDOM->CLOSE_TAG_RIGHT);
			if($equal) $equal = ($this->_text == $objDOM->_text);
				//echo "3º / ".($equal?"TRUE":"FALSE")."<br />";
			//4º COMPARACION RAPIDA. IGUAL NUMERO DE HIJOS
			if($equal) $equal = (count($objDOM->_children) == count($this->_children));
				//echo "4º / ".($equal?"TRUE":"FALSE")."<br />";
			//5º COMPARACION HIJO A HIJO
			if($equal){
				$contador=0;
				foreach($objDOM->_children as $clave=>$valor) {
					foreach($this->_children as $clave2=>$valor2) {
						if(($clave==$clave2) && ($valor==$valor2)) $contador++;
					}
				}
				$equal = ( (count($this->_children) == $contador) && (count($objDOM->_children) == $contador) );
				//echo "5º / ".($equal?"TRUE":"FALSE")."<br />";
			}
			//6º COMPARACION ATRIBUTO A ATRIBUTO
			if($equal) $equal = parent::equals($objDOM);
				//echo "6º / ".($equal?"TRUE":"FALSE")."<br /> - EQUAL=-|"; print_r($equal);echo "|-<br />";
			return $equal;
		}
		
		public function equalsType($objDOM) {
			return ( ($objDOM instanceof $this) && ($this->TYPE == $objDOM->TYPE ) );
		}
		//----------------  END: COMPARATOR  ------------------------
		
		//----------------  BEGIN: HTML  ----------------------------
		public function toHTML() {
			$HTML = $this->getOpenTag();
			if($this->getCloseTag() != "") $HTML .= self::$LINE_BREAK;
			$HTML .= ($this->TYPE == "textNode") ?  $this->getText(true) : ""; //$this->_text;
			foreach($this->getChildren() as $child){
			  $HTML .= $child->toHTML();
			}
			$HTML .= $this->getCloseTag() . self::$LINE_BREAK;
			//if($this->getCloseTag() == "") $HTML .= self::$LINE_BREAK;
			return $HTML;
			//return '<a '.parent::__toString().'>'.$this->_key.'</a>';
		}

		/**
		 * Metodo para obtener una etiqueta de definicion DTD que especifique el tipo de documento que estamos
		 * tratando. (HTML, XHTML, XML, ...)
		 * @param int $dtd Un entero identificando el tipo de DTD a retornar. Puede ser una de las constantes de
		 * esta clase que comienzan con DTD_
		 * @return string La cadena con el DTD solicitado.
		 **/
		public static function getDTD(int $dtd){
			//<?xml version="1.0" encoding="UTF-8"? >
			//<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
			//Copyright © 2014 W3C <sup>®</sup> (<a href="http://www.csail.mit.edu/"><acronym title="Massachusetts Institute of Technology">MIT</acronym></a>
			//<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			//<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			//HTML 2.0 :
				//<!DOCTYPE html PUBLIC "-//IETF//DTD HTML 2.0//EN">
			//HTML 3.2 :
				//<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
			//HTML 4.01 :
				//	(STRICT)
				//<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
				//	(TRANSITIONAL)
				//<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
				//	(FRAMSET)
				//<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
			//XHTML 1.0 :
				//	(STRICT)
				//<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
				//	(TRANSITIONAL)
				//<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				//	(FRAMSET)
				//<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
			//XHTML Basic 1.0 :
				//<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.0//EN" "http://www.w3.org/TR/xhtml-basic/xhtml-basic10.dtd">
			//XHTML Basic 1.1 :
				//<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN" "http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">
			//HTML 5 :
				//<!DOCTYPE HTML>
			switch ($dtd){
				case self::$DTD_DOCTYPE_HTML:
					return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
				case self::$DTD_DOCTYPE_XHTML_TRANSITIONAL:
					return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
				case self::$DTD_DOCTYPE_XHTML_STRICT:
					return'<?xml version="1.0" encoding="iso-8859-1"?>
								 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
				case self::$DTD_XML_1_0:
					return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
				default:
					;
			}
		}
		//----------------  END: HTML  ------------------------------
		
		//----------------  BEGIN: JSON  ----------------------------
		public function toJSON($return=true, $base64values=true) {
			$id =$this->getKey()?('-'.$this->getKey()):'';
			$id .=$this->getType()?('-'.$this->getType()):'';
			$id .='-' . rand(5, 1000);
			//$result ='"'.__CLASS__ . $id .'":{';
			$result ='{"_base64":"'.($base64values?'true':'false').'",';
			$array = array ();
			//PROPIEDADES:
			foreach (get_object_vars($this) as $clave=>$valor){
				if( !is_array($valor) && !is_object($valor)){
					//$clave = htmlentities(htmlspecialchars(utf8_encode($clave)));
					if($clave != "_text"){	//PARA TEXT YA OCURRE EL ESCAPE EN SU PROPIO METODO setText();
						$clave = addslashes( htmlspecialchars( utf8_encode($clave) ) );
						$valor = addslashes( htmlspecialchars( utf8_encode($valor) ) );
					}
					$clave=parent::filtrarStrJSON($clave);
					$valor=parent::filtrarStrJSON($valor);
					if($base64values) {
						$array[] = '"'.$clave.'":"'.base64_encode($valor).'"';
					}else{
						$array[] = '"'.$clave.'":"'.$valor.'"';
					}
				}
			}
			$result .= implode(',', $array).',';
			//$result .='"_children":'.json_encode($this->_children).",";
			//ATTRIBS
			$result .= '"_attribs":'.parent::toJSON($return, $base64values).',';
			//CHILDREN
			$array=array();
			foreach ($this->getChildren() as $key => $value) {
				if ( is_object($value) ){ //OBJETOS DOM (NO ATTRIBS NI PROPIEDADES)
					$array[] = $value->toJSON($return,$base64values);
				}
			}
			$result .= '"_children":['.implode(',', $array).']';
		
			$result .='}';
				
			if ($return) {
				return $result;
			} else {
				echo "<pre>";
				print $result;
				echo "</pre>";
				return null;
			}
		}

		public function fromJSON($json) {
			//DECODIFICAR LA CADENA JSON Y OBTENER EL OBJETO
			$result = json_decode(utf8_decode(htmlspecialchars_decode(stripslashes($json))));
			//DETECTAR AUTOMATICAMENTE SI HA SIDO CODIFICADO EN BASE64
			$base64values = key_exists("_base64", get_object_vars($result))? ($result->_base64=="true") : false;
			//CONVIERTO EL OBJ-JSON A OBJ-DOM_ELEMENT
			$object=self::objJSON2DOM_element( $result, true, $base64values );
			//ASIGNA Y RETORNA THIS COMO EL NUEVO OBJETO...
			return $this->fromDOM_element($object);
		}
		
		/**
		 * <p>Metodo estatico para construir un objeto DOM a la imagen y semejanza del objeto JSON entregado que deberia representar 
		 * otro DOM_element con hijos, atributos, y caracteristicas propias.</p>
		 * <p>NI QUE DECIR TIENE QUE EL OBJETO JSON ENTREGADO DEBE SER UN FIEL REFLEJO DE ALGUN ELEMENTO DE ESTA CLASE, 
		 * NORMALMENTE SE OBTENDRA DECODIFICANDO EL RETORNO DE LA FUNCION toJSON(); (json_decode(...->toJSON();))</p>
		 * @param JSON $objectJSON Es un objeto creado con una cadena JSON.
		 * @param boolean $return Expresa si retornar (TRUE) el objeto creado o imprimirlo (FALSE).
		 * @param boolean $base64values Indica si codificar los textos en 'base64' o no.
		 * @return DOM_element El elemento (DOM_element) creado equivalente al objeto entregado o NULL en caso de impresion.
		 **/
		public static function objJSON2DOM_element($objectJSON, $return=true, $base64values=true){
			//$object es un 'Objeto stdClass' convertido de una cadena valida JSON 
			$object=null;
			if(is_object($objectJSON)){
				$object=new DOM_element();
				foreach (get_object_vars($objectJSON) as $clave=>$valor){
					if(is_array($valor)){	//OBJECT
						//$object->setAttribs($valor);
						//$object->addChildren($valor);
						foreach ($valor as $key=>$value){
							$object->addChild( $object->objJSON2DOM_element( $value , $return, $base64values ) );
						}
					}elseif(is_object($valor)){	//ATTRIBS
						//$object->setAttribs($valor);
						foreach (get_object_vars($valor) as $key=>$value){
							$object->addAttrib($key, ($base64values ? base64_decode( $value ) : $value));
						}
					}else {//if( !is_array($valor) && !is_object($valor)){ //PARAM
						if($clave=="_base64") continue;
						//if($clave=="TYPE") echo "<p>TYPE:".$valor."</p>";
						$object->$clave = $base64values ? base64_decode( $valor ) : $valor;
						//if($clave=="TYPE") echo "<p>".$clave.":".$valor." || ".$object->$clave."</p>";
					}
				}
			}
			
			if ($return) {
				return $object;
			} else {
				echo "<pre>";
				print_r ($object);
				echo "</pre>";
				return null;
			}
		}
		//----------------  END: JSON  ------------------------------
		
		/**
		 * <p>Metodo para reconstruir este objeto a la imagen y semejanza del objeto DOM_element entregado, con hijos, atributos,
		 * y caracteristicas propias.</p>
		 * @param DOM_element $dom Un objeto de esta clase.
		 * @return DOM_element Este elemento (this) recreado equivalente (pero no el mismo) al objeto entregado.
		 **/
		public function fromDOM_element(DOM_element $dom){
			//$this=new $dom($dom->_key);
			$this->setReadOnly(false);
			$this->_Key = $dom->getKey();
			$this->setConfiguration($dom->getConfiguration());
			$this->setChildren($dom->getChildren());
			$this->setAttribs($dom->getAttribs());
			$this->setReadOnly($dom->getReadOnly());
			return $this;	//DA ERRORES EN PHP 4.0
		}
		
		//----------------  BEGIN URL  ------------------------------
		/** 
		 * <p>Retorna una cadena con el formato de las URL's, construida con los Atributos de este Objeto.<br />
		 * Contiene un parametro $encode indicando el tipo de codificacion a aplicar: 'RFC_1738' (espacios=+) o 'RFC_3986' (espacions=%20),
		 * las cuales estan implementadas como cadenas staticas de la clase DOM_attribs.</p>
		 * @param $encode Cadena indicando el tipo de codificacion (alguna de las dos constantes indicadas
		 * {@link DOM_attribs->ENCODE_RFC_1738 RFC_1738} o {@link DOM_attribs#ENCODE_RFC_3986 RFC_3986}).
		 * @return Cadena con formato de codificacion URL. 
		 **/
		public function attribsToURL($encode = self::ENCODE_RFC_1738){
			return parent::toURL($encode);
		}
		/**
		 * <p>Establece y retorna un array de atributos con sus correspondientes valores extraidos de una cadena con el formato de las URL's, 
		 * para construir Atributos de este Objeto.</p>
		 * <p>El parametro es la cadena desde la que se extraeran los atributos y sus valores, esta cadena tendra el formato entregado en
		 * las URL's como parte de su 'queryString' (entre '?' y '#'), Igual a la generada por el metodo toURL().</p>
		 * @param $encode Cadena indicando el tipo de codificacion (alguna de las dos constantes indicadas
		 * {@link DOM_attribs->ENCODE_RFC_1738 RFC_1738} o {@link DOM_attribs#ENCODE_RFC_3986 RFC_3986}).
		 * @return Array de atributos extraidos de la queryString.
		 **/
		public function attribsFromURL($strURL){
			return parent::fromURL($strURL);
		}
		//-----------------  END URL ----------------------------
		
		//-----------------  BEGIN: CONFIGURACION  --------------
		public function getConfiguration(){
			/*$conf=array($this->_READ_ONLY, $this->AVISO_GET, 
									$this->TAG, $this->TYPE, $this->DESC, $this->_text,
									$this->OPEN_TAG_LEFT, $this->OPEN_TAG_RIGHT, $this->CLOSE_TAG_LEFT, $this->CLOSE_TAG_RIGHT );*/
			$conf=array("_READ_ONLY"=>$this->_READ_ONLY, "AVISO_GET"=>$this->AVISO_GET,
									"TAG"=>$this->TAG, "TYPE"=>$this->TYPE, "DESC"=>$this->DESC, "_text"=>$this->_text,
									"OPEN_TAG_LEFT"=>$this->OPEN_TAG_LEFT, "OPEN_TAG_RIGHT"=>$this->OPEN_TAG_RIGHT, 
									"CLOSE_TAG_LEFT"=>$this->CLOSE_TAG_LEFT, "CLOSE_TAG_RIGHT"=>$this->CLOSE_TAG_RIGHT );
			return $conf;
		}

		public function setConfiguration(array $conf){
			try{
				$this->tryingWrite("[".$this->_key."]".$this->TAG);

				if( ! is_null($conf) ){
					/*$conf=array($this->_READ_ONLY, $this->AVISO_GET,
							$this->TAG, $this->TYPE, $this->DESC, $this->_text,
							$this->OPEN_TAG_LEFT, $this->OPEN_TAG_RIGHT, $this->CLOSE_TAG_LEFT, $this->CLOSE_TAG_RIGHT );
					*/
					foreach ($conf as $clave=>$valor){
						//echo $clave." = ".$value."<br />";
						$this->$clave=$valor;
						//if($clave=="TYPE") echo "<p>TYPE:".$valor."</p>";
						//echo (is_array($conf)?"true":"false")." :: ".$clave."-".$valor."<br />";
					}
				}

			}catch(Exception $e){
				$this->writeLog($e->getMessage(), $e->getTrace());
			}
			//return $conf;
			return $this;
		}
		
		public function importConfINI($confFile=null){
			// Analizar con secciones
			$seccIni = parse_ini_file(_PATH_CLASS_DOM_."/"._CONF_INI_FILE_DOM_, true);
			foreach ($seccIni as $secc=>$items){
				if($secc==_SECC_CONF_INI_DOM){
					/*
					foreach ($items as $key=>$value){
						echo $key." = ".$value."<br />";
					}
					*/
					$this->setConfiguration($items);
				}
			}
			return $this;
		}
		//---------------  END: CONFIGURACION  ----------------

	}
?>