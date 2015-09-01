<?php
/*
 * File containing the DOMBasicAutoloadException class
 *
 * @package DOMBasic
 * @version 1.0
 * @copyright Copyright (C) 2014-2020 Juan Jose Guerra Haba. All rights reserved.
 * @license http://www.jumla-droid.com/licenses/new_bsd New BSD License
 */
/**
 * DOMBasicAutoloadException is thrown whenever a class can not be found with
 * the autoload mechanism.
 *
 * @package DOMBasic
 * @version 1.0
 */
class DOMBasicAutoloadException extends DOMBasicException
{
    /**
     * Constructs a new DOMBasicAutoloadException for the $className that was
     * searched for in the autoload files $fileNames from the directories
     * specified in $dirs.
     *
     * @param string $className
     * @param array(string) $files
     * @param array(DOMBasicRepositoryDirectory) $dirs
     */
    function __construct( $className, $files, $dirs )
    {
        $paths = array();
        foreach ( $dirs as $dir )
        {
            $paths[] = realpath( $dir->autoloadPath );
        }
        parent::__construct( "Could not find a class to file mapping for '{$className}'. Searched for ". implode( ', ', $files ) . " in: " . implode( ', ', $paths ) );
    }
}
?>
