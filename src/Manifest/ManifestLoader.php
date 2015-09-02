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
     * @var PathMapperInterface
     */
    private $pathMapper;

    /**
     * @param PathMapperInterface $pathMapper
     */
    public function __construct(PathMapperInterface $pathMapper)
    {
        $this->pathMapper = $pathMapper;
    }

    /**
     * @param \SplFileInfo $manifestFile
     * @param string       $build
     * @param bool         $development
     * @return Manifest
     */
    public function loadManifest(\SplFileInfo $manifestFile, $build, $development = false)
    {
        $manifest = json_decode(file_get_contents($manifestFile->getPathname()), true);

        $pathMapper = function ($path) use ($build, $development) {
            return $this->pathMapper->mapPath($path, $build, $development);
        };

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

        return new Manifest($manifestFile->getPathname(), $manifest);
    }
}
