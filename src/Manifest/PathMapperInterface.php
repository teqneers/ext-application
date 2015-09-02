<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 02.09.15
 * Time: 11:41
 */

namespace TQ\ExtJS\Application\Manifest;

/**
 * Interface PathMapperInterface
 *
 * @package TQ\ExtJS\Application\Manifest
 */
interface PathMapperInterface
{
    /**
     * @param string $path
     * @param string $build
     * @param bool   $development
     * @return string
     */
    public function mapPath($path, $build, $development);
}
