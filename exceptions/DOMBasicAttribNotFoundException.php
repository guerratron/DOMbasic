<?php
/*
 * File containing the DOMBasicAttribNotFoundException class
 *
 * @package DOMBasic
 * @version 1.0
 * @copyright Copyright (C) 2014-2020 Juan Jose Guerra Haba. All rights reserved.
 * @license http://www.jumla-droid.com/licenses/new_bsd New BSD License
 */
/**
 * DOMBasicAttribNotFoundException is thrown whenever a non existent property
 * is accessed in the Components library.
 *
 * @package DOMBasic
 * @version 1.0
 */
class DOMBasicAttribNotFoundException extends DOMBasicException{
		/**
     * Constructs a new DOMBasicAttribNotFoundException for the attrib
     * $name.
     *
     * @param string $name The name of the attrib
     */
    function __construct( $name ) {
        parent::__construct( "No such attrib name '{$name}'." );
    }
}
?>
