<?php
/**
 * teqneers/ext-application
 *
 * @category   TQ
 * @package    TQ\ExtJS\Application
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace TQ\ExtJS\Application\Configuration;

/**
 * Class ApplicationConfiguration
 *
 * @package TQ\ExtJS\Application\Configuration
 */
class ApplicationConfiguration
{
    /**
     * @var string
     */
    protected $appPath;

    /**
     * @var array
     */
    protected $builds = [];

    /**
     * @var string|null
     */
    protected $defaultBuild;

    /**
     * @param string $appPath
     */
    public function __construct($appPath)
    {
        $this->appPath = rtrim($appPath, '/');
    }

    /**
     * @param string $name
     * @param array  $development
     * @param array  $production
     * @return $this
     */
    public function addBuild($name, array $development, array $production)
    {
        $this->builds[$name] = [
            'development' => $this->resolveBuildConfiguration($development),
            'production'  => $this->resolveBuildConfiguration($production)
        ];
        if ($this->defaultBuild === null) {
            $this->defaultBuild = $name;
        }

        return $this;
    }

    /**
     * @param array $config
     * @return array
     */
    private function resolveBuildConfiguration(array $config)
    {
        $config = array_replace([
            'build_path'  => null,
            'microloader' => null,
            'manifest'    => null,
            'app_cache'   => null,
        ], $config);

        if (empty($config['build_path'])) {
            throw new \InvalidArgumentException('Build path cannot be empty');
        } else {
            $config['build_path'] = $this->appPath . '/' . trim($config['build_path'], '/');
        }

        $config['microloader'] = $this->resolveBuildArtifactPathConfig($config['microloader'], $config['build_path']);
        $config['manifest']    = $this->resolveBuildArtifactPathConfig($config['manifest'], $config['build_path']);
        $config['app_cache']   = $this->resolveBuildArtifactPathConfig($config['app_cache'], $config['build_path']);

        return $config;
    }

    /**
     * @param string $artifactPath
     * @param string $buildPath
     * @return string
     */
    private function resolveBuildArtifactPathConfig($artifactPath, $buildPath)
    {
        if (strpos($artifactPath, '/') === 0) {
            return $this->appPath . '/' . trim($artifactPath, '/');
        } else {
            return $buildPath . '/' . trim($artifactPath, '/');
        }
    }

    /**
     * @param string|null $name
     * @param bool        $development
     * @return array
     */
    protected function getBuild($name, $development)
    {
        if ($name === null) {
            if ($this->defaultBuild !== null) {
                $name = $this->defaultBuild;
            } else {
                throw new \BadMethodCallException('No build name given but no default build exists');
            }
        }

        if (!isset($this->builds[$name])) {
            throw new \InvalidArgumentException('Build "' . $name . '" does not exist');
        }
        return $development ? $this->builds[$name]['development'] : $this->builds[$name]['production'];
    }

    /**
     * @param string|null $name
     * @param string      $key
     * @param bool        $development
     * @return string|null
     */
    protected function getFromBuild($name, $key, $development)
    {
        $build = $this->getBuild($name, $development);
        if (isset($build[$key])) {
            return $build[$key];
        } else {
            return null;
        }
    }

    /**
     * @param string|null $name
     * @param bool        $development
     * @return string
     */
    public function getBuildPath($name = null, $development = false)
    {
        return $this->getFromBuild($name, 'build_path', $development);
    }

    /**
     * @param string|null $name
     * @param bool        $development
     * @return string
     */
    public function getMicroLoaderPath($name = null, $development = false)
    {
        return $this->getFromBuild($name, 'microloader', $development);
    }

    /**
     * @param string|null $name
     * @param bool        $development
     * @return string
     */
    public function getManifestPath($name = null, $development = false)
    {
        return $this->getFromBuild($name, 'manifest', $development);
    }

    /**
     * @param string|null $name
     * @param bool        $development
     * @return string|null
     */
    public function getAppCachePath($name = null, $development = false)
    {
        return $this->getFromBuild($name, 'app_cache', $development);
    }

    /**
     * @param string      $path
     * @param string|null $name
     * @param bool        $development
     * @return \SplFileInfo
     */
    public function getBuildArtifactPath($path, $name = null, $development = false)
    {
        $buildPath         = $this->getBuildPath($name, $development);
        $relativeBuildPath = str_replace($this->appPath, '', $buildPath);

        if (strpos($path, 'resources/ext-watermark') !== false) {
            $path = str_replace('resources/ext-watermark', 'resources/ext/ext-watermark', $path);
        }

        if (strpos($path, $relativeBuildPath) === 0 || $development) {
            return $this->appPath . '/' . $path;
        } else {
            return $buildPath . '/' . trim($path, '/');
        }
    }

    /**
     * @return string|null
     */
    public function getDefaultBuild()
    {
        return $this->defaultBuild;
    }
}
