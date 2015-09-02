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
 * Class ManifestLoader
 *
 * @package TQ\ExtJS\Application\Manifest
 */
class ManifestLoader
{
    /**
     * @param callable     $pathMapper
     * @param \SplFileInfo $manifestFile
     * @param bool         $development
     * @return Manifest
     */
    public function loadManifest(callable $pathMapper, \SplFileInfo $manifestFile, $development = false)
    {
        $manifest = json_decode(file_get_contents($manifestFile->getPathname()), true);

        $mapArray = function (array $u) use ($pathMapper) {
            $u['path'] = $pathMapper($u['path']);
            return $u;
        };

        $manifest['js']  = array_map($mapArray, $manifest['js']);
        $manifest['css'] = array_map($mapArray, $manifest['css']);

        if ($development && isset($manifest['paths'])) {
            $manifest['paths'] = array_map($pathMapper, $manifest['paths']);
        }

        if ($development && isset($manifest['loadOrder'])) {
            $manifest['loadOrder'] = array_map($mapArray, $manifest['loadOrder']);
        }

        return new Manifest($manifest);
    }
}
