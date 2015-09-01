<?php
/*
 * File containing the DOMBasicException class.
 *
 * @package DOMBasic
 * @version 1.0
 * @copyright Copyright (C) 2014-2020 Juan Jose Guerra Haba. All rights reserved.
 * @license http://www.jumla-droid.com/licenses/new_bsd New BSD License
 */
/**
 * DOMBaseException is a container from which all other exceptions in the
 * components library descent.
 *
 * @package DOMBase
 * @version 1.0
 */
abstract class DOMBasicException extends Exception {
    /**
     * Original message, before escaping
     */
    public $originalMessage;

    /**
     * Constructs a new DOMBasicException with $message
     *
     * @param string $message
     */
    public function __construct( $message ) {
        $this->originalMessage = $message;

        if ( php_sapi_name() == 'cli' ) {
            parent::__construct( $message );
        } else {
            parent::__construct( htmlspecialchars( $message ) );
        }
    }
}
?>
