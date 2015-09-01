<?php
/*
 * File containing the DOMBasicElementNotFoundException class
 *
 * @package DOMBasic
 * @version 1.0
 * @copyright Copyright (C) 2014-2020 Juan Jose Guerra Haba. All rights reserved.
 * @license http://www.jumla-droid.com/licenses/new_bsd New BSD License
 */
/**
 * DOMBasicElementNotFoundException is thrown whenever a non existent element
 * is accessed in the elements array.
 *
 * @package DOMBasic
 * @version 1.0
 */
class DOMBasicElementNotFoundException extends DOMBasicException{
		/**
     * Constructs a new DOMBasicElementNotFoundException for the element
     * $name.
     *
     * @param string $name The name of the element
     */
    function __construct( $name ) {
        parent::__construct( "No such element name '{$name}'." );
    }
}
?>
