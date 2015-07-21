<?php
/**
 * teqneers/ext-application
 *
 * @category   TQ
 * @package    TQ\ExtJS\Application
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace TQ\ExtJS\Application;

/**
 * Class ManifestLoader
 *
 * @package TQ\ExtJS\Application
 */
class ManifestLoader
{
    /**
     * @param string       $basePath
     * @param \SplFileInfo $manifestFile
     * @param bool         $development
     * @return Manifest
     */
    public function loadManifest($basePath, \SplFileInfo $manifestFile, $development = false)
    {
        $manifest = json_decode(file_get_contents($manifestFile->getPathname()), true);

        $mapPath = function ($p) use ($basePath) {
            return $basePath . '/' . $p;
        };

        $mapArray = function (array $u) use ($mapPath) {
            $u['path'] = $mapPath($u['path']);
            return $u;
        };

        $manifest['js']  = array_map($mapArray, $manifest['js']);
        $manifest['css'] = array_map($mapArray, $manifest['css']);

        if ($development && isset($manifest['paths'])) {
            $manifest['paths'] = array_map($mapPath, $manifest['paths']);
        }

        if ($development && isset($manifest['loadOrder'])) {
            $manifest['loadOrder'] = array_map($mapArray, $manifest['loadOrder']);
        }

        return new Manifest($manifest);
    }
}
