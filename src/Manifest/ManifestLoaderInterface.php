<?php
/**
 * TQ\ExtJS\Application\Manifest\ManifestLoaderInterface
 *
 * @author    stefan
 * @package   TQ\ExtJS\Application\Manifest
 * @copyright Copyright (C) 2003-2016 TEQneers GmbH & Co. KG. All rights reserved.
 */

namespace TQ\ExtJS\Application\Manifest;

/**
 * Interface ManifestLoaderInterface
 *
 * @package TQ\ExtJS\Application\Manifest
 */
interface ManifestLoaderInterface
{
    /**
     * @param \SplFileInfo $manifestFile
     * @param string       $build
     * @param bool         $development
     * @return Manifest
     */
    public function loadManifest(\SplFileInfo $manifestFile, $build, $development = false);
}
