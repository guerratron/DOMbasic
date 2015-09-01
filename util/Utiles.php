<?php

/**
 * Igual a la funcion original PHP 'var_export(...)', pero mejorados los arrays (de forma recursiva)
 * <p>DESCARGADO DE php.net: http://es1.php.net/manual/es/function.var-export.php. AUTHOR: linus at flowingcreativity dot net</p>
 **/
function var_export_min($var, $return = false) {
	if (is_array($var)) {
		$toImplode = array();
		foreach ($var as $key => $value) {
			$toImplode[] = var_export($key, true).'=>'.var_export_min($value, true);
		}
		$code = 'array('.implode(',', $toImplode).')';
		if ($return) return $code; else echo $code;
	} else {
		return var_export($var, $return);
	}
}
/**
 * <p>DESCARGADO DE php.net: http://es1.php.net/manual/es/function.var-export.php. AUTHOR: wyattstorch42 at outlook dot com</p>
 * <p>Igual a la funcion original PHP 'var_export(...)', pero mejorados los arrays (de forma recursiva), y corregido un bug
 * con los objetos <b>StdClass()</b> que no implementan el metodo <b>__set_state()</b></p>
 * An implementation of var_export() that is compatible with instances of stdClass.
 * <pre>
 *
 // Example usage:
 $obj = new stdClass;
 $obj->test = 'abc';
 $obj->other = 6.2;
 $obj->arr = array (1, 2, 3);

 improved_var_export((object) array (
 'prop1' => true,
 'prop2' => $obj,
 'assocArray' => array (
 'apple' => 'good',
 'orange' => 'great'
 )
 ));
 Output:
(object) array ('prop1' => true, 'prop2' => (object) array ('test' => 'abc', 'other' => 6.2, 
'arr' => array (0 => 1, 1 => 2, 2 => 3)), 'assocArray' => array ('apple' => 'good', 'orange' => 'great'))
 * </pre>
 * @param mixed $variable The variable you want to export
 * @param bool $return If used and set to true, improved_var_export()
 *     will return the variable representation instead of outputting it.
 * @return mixed|null Returns the variable representation when the
 *     return parameter is used and evaluates to TRUE. Otherwise, this
 *     function will return NULL.
 */
function improved_var_export ($variable, $return = false) {
	if ($variable instanceof stdClass) {
		$result = '(object) '.improved_var_export(get_object_vars($variable), true);
	} else if (is_array($variable)) {
		$array = array ();
		foreach ($variable as $key => $value) {
			$array[] = var_export($key, true).' => '.improved_var_export($value, true);
		}
		$result = 'array ('.implode(', ', $array).')';
	} else {
		$result = var_export($variable, true);
	}

	if (!$return) {
		print $result;
		return null;
	} else {
		return $result;
	}
}

/**
 * Here's a very useful function to translate <b>Microsoft</b> characters into <b>Latin 15</b>, so that people won't see any more 
 * square instead of characters in web pages .
 **/
function demicrosoftize($str) {
	return strtr($str,
			"\x82\x83\x84\x85\x86\x87\x89\x8a" .
			"\x8b\x8c\x8e\x91\x92\x93\x94\x95" .
			"\x96\x97\x98\x99\x9a\x9b\x9c\x9e\x9f",
			"'f\".**^\xa6<\xbc\xb4''" .
			"\"\"---~ \xa8>\xbd\xb8\xbe");
}
?>