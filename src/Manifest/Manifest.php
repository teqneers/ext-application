<?php
/**
 * teqneers/ext-application
 *
 * @category   TQ
 * @package    TQ\ExtJS\Application
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace TQ\ExtJS\Application\Manifest;

/**
 * Class Manifest
 *
 * @package TQ\ExtJS\Application\Manifest
 */
class Manifest
{
    /**
     * @var array
     */
    private $manifest;

    /**
     * @param array $manifest
     */
    public function __construct(array $manifest)
    {
        $this->manifest = $manifest;
    }

    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->manifest);
    }
}
