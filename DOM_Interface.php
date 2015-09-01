<?php
//define("TAG", "LinkClass");
	/**
	 * Interfaz para los elementos del DOM. Admite CONCATENACION DE METODOS mediante el retorno de la construccion '$this'
	 * en todos los metodos 'NO-GETTER'
	 **/
	interface DOM_Interface{
		/**
		 * Metodo para establecer la clave de este elemento DOM.
		 * @param $key string clave del elemento.
		 * @return DOM_element $this este elemento (DOM).
		 **/
		public function setKey(string $key=null);
		/**
		 * Metodo para tomar la clave del elemento.
		 * @return String con la clave de este elemento.
		 **/
		public function getKey();
		//public function setTag($tag);
		/**
		 * Metodo para leer la etiqueta DOM de este elemento.
		 * @return String con la etiqueta de este elemento DOM.
		 **/
		public function getTag();
		//public function setOpenTag($openTag);
		/**
		 * Metodo para leer la etiqueta HTML de apertura construida para este elemento, con sus atributos incluidos.
		 * @return String con la etiqueta HTML de apertura.
		 **/
		public function getOpenTag();
		//public function setCloseTag($closeTag);
		/**
		 * Metodo para leer la etiqueta HTML de cierre construida para este elemento, con sus atributos incluidos.
		 * <p>NOTE: Existen elementos que deben establecer la suya propia, como los elementos autocontendios (&lt;img />, &lt;/br >, ...) 
		 * o elementos sin etiqueta como 'textNode'.</p>
		 * @return String con la etiqueta HTML de cierre.
		 **/
		public function getCloseTag();
		//public function setType($type);
		/**
		 * Metodo para leer el tipo DOM de este elemento.
		 * @return String con el tipo de este elemento DOM.
		**/
		public function getType();
		//public function setDesc($desc);
		/**
		 * Metodo para leer la descripcion DOM de este elemento.
		 * @return String con la descripcion de este elemento DOM.
		 **/
		public function getDesc();

		/**
		 * Metodo para agregar un hijo al elemento DOM.
		 * @param $child Elemento DOM.
		 * @return DOM_element $this este elemento (DOM).
		 * @see DOM_Interface::addChildren()
		 * @see DOM_Interface::setChildren()
		 **/
		public function addChild(DOM_element $child=null);
		/**
		 * Metodo para agregar un array de hijos de elementos DOM, al ya existente.
		 * @param $child Elemento DOM.
		 * @return DOM_element $this este elemento (DOM).
		 * @see DOM_Interface::addChild()
		 * @see DOM_Interface::setChildren()
		**/
		public function addChildren(array $children=null);
		/**
		 * Metodo para establecer los hijos al elemento DOM. Estos hijos a su vez deben ser elementos DOM.
		 * @param $children Array Elementos del DOM.
		 * @return DOM_element $this este elemento (DOM).
		 * @see DOM_Interface::addChild()
		 * @see DOM_Interface::addChildren()
		 **/
		public function setChildren(array $children=null);
		
		/**
		 * Metodo para retornar el array de todos los hijos del elemento DOM. Similar a {@link DOM_Interface::getChildrenAll()}
		 * @return Array de elementos (DOM) con sus atributos correspondientes.
		 * @see DOM_Interface::getChildrenAll()
		 * @see DOM_Interface::getChildByKey()
		 * @see DOM_Interface::getChildrenByTag()
		 * @see DOM_Interface::getChildrenByType()
		 **/
		public function getChildren();
		/**
		 * Metodo para retornar un array con todos los hijos de forma recursiva (nietos, bisnietos, ...) del elemento DOM. Similar a {@link DOM_Interface::getChildren() }
		 * @return Array de elementos (DOM) con sus atributos correspondientes.
		 * @see DOM_Interface::getChildren()
		 * @see DOM_Interface::getChildByKey()
		 * @see DOM_Interface::getChildrenByTag()
		 * @see DOM_Interface::getChildrenByType()
		 **/
		public function getChildrenAll();
		/**
		 * <p>Metodo para buscar y retornar un hijo del elemento que contenga la misma clave que la pasada por parametro, este metodo
		 * es recursivo pero retorna el primer elemento que concuerde su clave, el segundo parametro (por defecto TRUE) indica si comprobar recursivamente en nietos...</p>
		 * CAUTION!: USE RECURSIVE FUNCTION!!
		 * @param string $key La clave del elemento a buscar.
		 * @param boolean $grandchildren TRUE=elimina recursivamente, FALSE=solo mira en los hijos directos.
		 * @return DOM_element Elemento si es que se encuentra, sino null.
		 * @see DOM_Interface::getChildrenByTag()
		 * @see DOM_Interface::getChildrenByType()
		 * @see DOM_Interface::getChildren()
		 * @see DOM_Interface::getChildrenAll()
		 **/
		public function getChildByKey($key, $grandchildren=true);
		/**
		 * <p>Metodo para buscar y retornar un array de hijos del elemento que contengan la misma etiqueta (TAG) que la pasada por 
		 * parametro, el segundo parametro (por defecto TRUE) indica si comprobar recursivamente en nietos...</p>
		 * CAUTION!: RECURSIVE FUNCTION!!
		 * @param string $tag La etiqueta (TAG) del elemento a buscar.
		 * @param boolean $grandchildren TRUE=elimina recursivamente, FALSE=solo mira en los hijos directos.
		 * @return array(DOM_element) si es que se encuentran, sino un array vacio.
		 * @see DOM_Interface::getChildByKey()
		 * @see DOM_Interface::getChildrenByType()
		 * @see DOM_Interface::getChildren()
		 * @see DOM_Interface::getChildrenAll()
		 **/
		public function getChildrenByTag($tag, $grandchildren=true);
		/**
		 * <p>Metodo para buscar y retornar un array de hijos del elemento que sean del mismo tipo (TYPE) que el pasado por
		 * parametro, el segundo parametro (por defecto TRUE) indica si comprobar recursivamente en nietos...</p>
		 * CAUTION!: RECURSIVE FUNCTION!!
		 * @param string $type El tipo (TYPE) del elemento a buscar.
		 * @param boolean $grandchildren TRUE=elimina recursivamente, FALSE=solo mira en los hijos directos.
		 * @return array(DOM_element) si es que se encuentran, sino un array vacio.
		 * @see DOM_Interface::getChildByKey()
		 * @see DOM_Interface::getChildrenByTag()
		 * @see DOM_Interface::getChildren()
		 * @see DOM_Interface::getChildrenAll()
		 **/
		public function getChildrenByType($type, $grandchildren=true);
		/**
		 * <p>Metodo para eliminar el hijo del elemento que sea el mismo ('equalsExact') que el pasado por parametro,
		 * Retorna el numero de elementos eliminados, Este metodo puede ser recursivo, el segundo parametro (por defecto TRUE) indica si comprobar recursivamente en nietos...</p>
		 * CAUTION!: USE RECURSIVE FUNCTION!!
		 * @param DOM_element $child El objeto hijo a eliminar.
		 * @param boolean $grandchildren TRUE(DEFAULT)=elimina recursivamente, FALSE=solo mira en los hijos directos.
		 * @return DOM_element $this este elemento (DOM).
		 * @see DOM_Interface::removeChildrenAll()
		 * @see DOM_Interface::removeChildByKey()
		 * @see DOM_Interface::removeChildrenByTag()
		 * @see DOM_Interface::removeChildrenByType()
		 **/
		public function removeChild($child, $grandchildren=true);
		/**
		 * <p>Elimina todos sus hijos (ELIMINA EL CONTENIDO ENTERO DE ESTE ELEMENTO).</p>
		 * @return DOM_element $this este elemento (DOM).
		 * @see DOM_Interface::removeChild()
		 * @see DOM_Interface::removeChildByKey()
		 * @see DOM_Interface::removeChildrenByTag()
		 * @see DOM_Interface::removeChildrenByType()
		 **/
		public function removeChildrenAll();
		/**
		 * <p>Metodo para eliminar el hijo del elemento que contengan la misma clave que la pasada por
		 * parametro, Este metodo es recursivo, el segundo parametro (por defecto TRUE) indica si comprobar recursivamente en nietos...</p>
		 * CAUTION!: USE RECURSIVE FUNCTION!!
		 * @param string $key La clave del elemento a eliminar.
		 * @param boolean $grandchildren TRUE=elimina recursivamente, FALSE=solo mira en los hijos directos.
		 * @return DOM_element $this este elemento (DOM).
		 * @see DOM_Interface::removeChild()
		 * @see DOM_Interface::removeChildrenAll()
		 * @see DOM_Interface::removeChildrenByTag()
		 * @see DOM_Interface::removeChildrenByType()
		 **/
		public function removeChildByKey($key, $grandchildren=true);
		/**
		 * <p>Metodo para eliminar los hijos del elemento que contengan la misma etiqueta (TAG) que la pasada por
		 * parametro, Retorna el numero de elementos eliminados, Este metodo es recursivo, el segundo parametro (por defecto TRUE) indica si comprobar recursivamente en nietos...</p>
		 * CAUTION!: USE RECURSIVE FUNCTION!!
		 * @param string $tag La etiqueta (TAG) del elemento a eliminar.
		 * @param boolean $grandchildren TRUE=elimina recursivamente, FALSE=solo mira en los hijos directos.
		 * @return DOM_element $this este elemento (DOM).
		 * @see DOM_Interface::removeChild()
		 * @see DOM_Interface::removeChildrenAll()
		 * @see DOM_Interface::removeChildByKey()
		 * @see DOM_Interface::removeChildrenByType()
		 **/
		public function removeChildrenByTag($tag, $grandchildren=true);
		/**
		 * <p>Metodo para eliminar los hijos del elemento que sean del mismo tipo (Type) que el pasado por parametro,
		 * Retorna el numero de elementos eliminados, Este metodo es recursivo, el segundo parametro (por defecto TRUE) indica si comprobar recursivamente en nietos...</p> 
		 * CAUTION!: USE RECURSIVE FUNCTION!!
		 * @param string $tag La etiqueta (TAG) del elemento a eliminar.
		 * @param boolean $grandchildren TRUE=elimina recursivamente, FALSE=solo mira en los hijos directos.
		 * @return DOM_element $this este elemento (DOM).
		 * @see DOM_Interface::removeChild()
		 * @see DOM_Interface::removeChildrenAll()
		 * @see DOM_Interface::removeChildByKey()
		 * @see DOM_Interface::removeChildrenByTag()
		 **/
		public function removeChildrenByType($type, $grandchildren=true);
		/** <p>Compara si otro objeto es del mismo TIPO que este (no si es el mismo)
		 * @param DOM_element $objDOM Algun objeto instancia de esta Clase
		 * @return boolean 
		 **/
		public function equalsType($objDOM);
		
		//----------------  BEGIN: HTML  ----------------------------
		/**
		 * Metodo para retornar la cadena que representa el HTML de este elemento DOM con sus atributos, y los de sus hijos, 
		 * correspondientes.
		 * @return String HTML de este elemento (DOM) con sus atributos correspondientes.
		 **/
		public function toHTML();
		//----------------  END: HTML  ----------------------------
		
		//----------------  BEGIN: JSON  ----------------------------
		/**
		 * <p>Metodo para retornar la cadena JSON que representa este elemento DOM con sus hijos y con sus atributos, 
		 * y los de sus hijos, correspondientes.</p>
		 * <p>RECOMENDADO: Aporta un segundo parametro para codificar todos los valores (no las claves) en 'base64', (DEFECTO=true), 
		 * asi podriamos evitar el problema de los tipos de codificacion empleados (JSON solo admite UTF-8).</p>
		 * <p>NO UTILIZA LA FUNCION PHP 'json_encode(..)'</p>
		 * <p><del>Utiliza las siguientes constantes PHP 5.3: JSON_HEX_QUOT && JSON_HEX_TAG && JSON_HEX_AMP && JSON_HEX_APOS</del></p>
		 * @param boolean $return Indica si retornar el resultado (TRUE) o imprimirlo (FALSE).
		 * @param boolean $base64values Indica si codificar los textos en 'base64' o no.
		 * @return String JSON de este elemento (DOM) con sus atributos correspondientes o NULL en caso de desear imprimirlo.
		 **/
		public function toJSON($return=true, $base64values=true);
		/**
		 * <p>Metodo para reconstruir este objeto a la imagen y semejanza de la cadena JSON entregada que deberia representar 
		 * otro DOM_element con hijos, atributos, y caracteristicas propias.</p>
		 * <p>Detecta AUTOMATICAMENTE si el objeto se codifico con 'base64'.</p>
		 * <p>UTILIZA LA FUNCION PHP 'json_decode()' con parametros por defecto.</p>
		 * @param string $json La cadena json que representa un objeto DOM_element. Esta cadena se construye con la funcion 
		 * contraria toJSON().
		 * @return DOM_element El elemento actual (this) reconstruido a la forma del objeto de entrada.
		 **/
		public function fromJSON($json);
		//----------------  END: JSON  ----------------------------

		//--------------- BEGIN: CONFIGURACION  ----------------
		/**
		 * Leer la configuracion de este elemento
		 * @return array
		 * @see DOM_Interface::setConfiguration()
		 * @see DOM_Interface::importConfINI()
		 */
		public function getConfiguration();
		/**
		 * Grabar la configuracion de este elemento
		 * @param array $conf Array asociativo de variables de configuracion en formato 'clave=valor'
		 * @return DOM_element $this este elemento (DOM).
		 * @see DOM_Interface::getConfiguration()
		 * @see DOM_Interface::importConfINI()
		*/
		public function setConfiguration(array $conf);
		//---------------   END: CONFIGURACION  ----------------
		/**
		 * <p>Importar las configuraciones desde el archivo config.ini, Utiliza la seccion del INI [CONF_SEC].</p>
		 * <p>Si no se entrega parametro de ruta se utilizara el archivo de configuracion por defecto ('config.ini') en la ruta
		 * del pakete.</p>
		 * <div style="background:yellow; color:navy;">
		 * <p>El archivo INI de configuracion debe tener una estructura INI adecuada, con sus secciones validas y sus variables y valores:</p>
		 * <p>Caracteres exclusivamente AlfaNumericos, o sino, encerrados entre comillas dobles ' " ', Lineas de Comentarios inician con punto y coma ' ; ', &hellip;</p>
		 * <ul>
		 * 	<caption>Debe contener como minimo las siguientes secciones:</caption>
		 * 	<li>[PK_SEC] : Seccion para identificacion del pakete.</li>
		 * 	<li>[CONSTS_SEC] : Seccion para las constantes de la clase (_PATH_CLASS_DOM_, _CONF_INI_FILE_DOM_, ...)</li>
		 * 	<li>[CONF_SEC] : Seccion para las variables de configuracion (TAG, _text,...)</li>
		 * </ul>
		 * <p>Para poder simular el incluir comillas dobles, se ha definido un 'token' (QUOTE), que puede utilizarse dentro del INI.</p>
		 * </div>
		 * @param string $confFile (OPCIONAL, DEFAULT=NULL) La ruta completa al archivo de configuracion INI a cargar.
		 * @return DOM_element $this este elemento (DOM) con sus atributos correspondientes.
		 * @see DOM_Interface::getConfiguration()
		 * @see DOM_Interface::setConfiguration()
		 */
		public function importConfINI($confFile=null);
	}
?>