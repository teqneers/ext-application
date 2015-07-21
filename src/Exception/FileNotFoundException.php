<?php
/**
 * teqneers/ext-application
 *
 * @category   TQ
 * @package    TQ\ExtJS\Application
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace TQ\ExtJS\Application\Exception;

use Exception;

/**
 * Class FileNotFoundException
 *
 * @package TQ\ExtJS\Application\Exception
 */
class FileNotFoundException extends \RuntimeException
{
    /**
     * @param string    $path
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct($path, $code = 0, Exception $previous = null)
    {
        parent::__construct(sprintf('File "%s" not found', $path), $code, $previous);
    }

}
