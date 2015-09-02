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
class Manifest extends \SplFileInfo
{
    /**
     * @var array
     */
    private $manifest;

    /**
     * @param string $path
     * @param array  $manifest
     */
    public function __construct($path, array $manifest)
    {
        parent::__construct($path);
        $this->manifest = $manifest;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return json_encode($this->manifest);
    }

    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getContent();
    }
}
