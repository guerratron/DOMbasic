<?php
/*
 * File containing the DOMBasicElementReadOnlyException class
 *
 * @package DOMBasic
 * @version 1.0
 * @copyright Copyright (C) 2014-2020 Juan Jose Guerra Haba. All rights reserved.
 * @license http://www.jumla-droid.com/licenses/new_bsd New BSD License
 */
/**
 * DOMBasicElementReadOnlyException is thrown whenever a read-only element DOM
 * is tried to be changed.
 *
 * @package DOMBasic
 * @version 1.0
 */
class DOMBasicElementReadOnlyException extends DOMBasicException
{
    /**
     * Used when the element is read-only.
     */
    const READ  = 1;

    /**
     * Used when the element is write-only.
     */
    const WRITE = 2;

    /**
     * Constructs a new DOMBasicElementReadOnlyException for the element $keyTag.
     *
     * @param string $keyTag The key and TAG of the element.
     * @param int    $mode The mode of the element that is allowed (::READ or ::WRITE).
     */
    function __construct( $keyTag, $mode )
    {
        parent::__construct( "The element '{$keyTag}' is " .
            ( $mode == self::READ ? "read" : "write" ) .
            "-only." );
    }
}
?>
