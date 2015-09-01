<?php
/*
 * File containing the DOMBasicValueException class.
 *
 * @package DOMBasic
 * @version 1.0
 * @copyright Copyright (C) 2014-2020 Juan Jose Guerra Haba. All rights reserved.
 * @license http://www.jumla-droid.com/licenses/new_bsd New BSD License
 */
/**
 * DOMBasicValueException is thrown whenever the type or value of the given
 * variable is not as expected.
 *
 * @package DOMBasic
 * @version 1.0
 */
class DOMBasicValueException extends DOMBasicException {
    /**
     * Constructs a new DOMBasicValueException on the $name variable.
     *
     * @param string  $attribName The name of the attrib where something was
     *                wrong with.
     * @param mixed   $value The value that the option was tried to be set too.
     * @param string  $expectedValue A string explaining the allowed type and value range.
     * @param string  $variableType  What type of variable was tried to be set (option, attrib, setting, argument).
     */
    function __construct( $attribName, $value, $expectedValue = null, $variableType = 'attrib' ) {
        $type = gettype( $value );
        if ( in_array( $type, array( 'array', 'object', 'resource' ) ) ) {
            $value = serialize( $value );
        }
        $msg = "The value '{$value}' that you were trying to assign to $variableType '{$attribName}' is invalid.";
        if ( $expectedValue ) {
            $msg .= " Allowed values are: " . $expectedValue . '.';
        }
        parent::__construct( $msg );
    }
}
?>
