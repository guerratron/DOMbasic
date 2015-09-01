<?php
/*
 * File containing the DOMBasicAttribReadOnlyException class
 *
 * @package DOMBasic
 * @version 1.0
 * @copyright Copyright (C) 2014-2020 Juan Jose Guerra Haba. All rights reserved.
 * @license http://www.jumla-droid.com/licenses/new_bsd New BSD License
 */
/**
 * DOMBasicAttribReadOnlyException is thrown whenever a read-only attrib
 * is tried to be changed, or when a write-only attrib was accessed for reading.
 *
 * @package DOMBasic
 * @version 1.0
 */
class DOMBasicAttribReadOnlyException extends DOMBasicException
{
    /**
     * Used when the attrib is read-only.
     */
    const READ  = 1;

    /**
     * Used when the attrib is write-only.
     */
    const WRITE = 2;

    /**
     * Constructs a new DOMBasicAttribReadOnlyException for the attrib $name.
     *
     * @param string $name The name of the attrib.
     * @param int    $mode The mode of the attrib that is allowed (::READ or ::WRITE).
     */
    function __construct( $name, $mode )
    {
        parent::__construct( "The attrib '{$name}' is " .
            ( $mode == self::READ ? "read" : "write" ) .
            "-only." );
    }
}
?>
