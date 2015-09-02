<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 02.09.15
 * Time: 11:42
 */

namespace TQ\ExtJS\Application\Manifest;

/**
 * Class StaticPathMapper
 *
 * @package TQ\ExtJS\Application\Manifest
 */
class StaticPathMapper implements PathMapperInterface
{
    /**
     * @var string
     */
    private $basePath;

    /**
     * @param string $basePath
     */
    public function __construct($basePath)
    {
        $this->basePath = rtrim($basePath, '/');
    }

    /**
     * {@inheritdoc}
     */
    public function mapPath($path, $build, $development)
    {
        if (substr($path, 0, 1) === '/') {
            return $path;
        }

        return $this->basePath . '/' . $path;
    }
}
