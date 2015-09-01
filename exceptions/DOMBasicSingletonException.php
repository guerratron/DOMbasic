<?php
/*
 * File containing the DOMBasicSingletonException class
 *
 * @package DOMBasic
 * @version 1.0
 * @copyright Copyright (C) 2014-2020 Juan Jose Guerra Haba. All rights reserved.
 * @license http://www.jumla-droid.com/licenses/new_bsd New BSD License
 */
/**
 * DOMBasicSingletonException is thrown whenever a static instance element
 * is tried to get, field $PATRON_SINGLETON dependency in CONFIGURATION.
 *
 * @package DOMBasic
 * @version 1.0
 */
class DOMBasicSingletonException extends DOMBasicException {
    /**
     * Constructs a new DOMBasicSingletonException for the elements and attribs.
     */
    function __construct(  ) {
        parent::__construct( "DENEGATE PATRON SINGLETON !! FIRST ACTIVATE!!" );
    }
}
?>
