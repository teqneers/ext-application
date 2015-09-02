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
     * @var string
     */
    private $content;

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
    public function computeETag()
    {
        return md5($this->getContent());
    }

    /**
     * @return string
     */
    public function getContent()
    {
        if (!$this->content) {
            $this->content = json_encode($this->manifest);
        }
        return $this->content;
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
