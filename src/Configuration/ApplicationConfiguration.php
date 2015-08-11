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
    protected $webPath;

    /**
     * @var string
     */
    protected $relativeWebUrl;

    /**
     * @var string
     */
    protected $workspacePath;

    /**
     * @var string
     */
    protected $relativeWorkspaceUrl;

    /**
     * @var array
     */
    protected $builds = [];

    /**
     * @var string|null
     */
    protected $defaultBuild;

    /**
     * @param string $workspacePath
     * @param string $relativeWorkspaceUrl
     * @param string $webPath
     * @param string $relativeWebUrl
     */
    public function __construct(
        $workspacePath,
        $relativeWorkspaceUrl,
        $webPath,
        $relativeWebUrl = '/'
    ) {
        $this->workspacePath        = rtrim($workspacePath, '/');
        $this->relativeWorkspaceUrl = trim($relativeWorkspaceUrl, '/');
        $this->webPath              = rtrim($webPath, '/');
        $this->relativeWebUrl       = trim($relativeWebUrl, '/');
    }

    /**
     * @param string $name
     * @param string $developmentBase
     * @param string $productionBase
     * @param string $developmentManifest
     * @param string $developmentMicroLoader
     * @param string $productionManifest
     * @param string $productionMicroLoader
     * @return $this
     */
    public function addBuild(
        $name,
        $developmentBase,
        $productionBase,
        $developmentManifest = 'bootstrap.json',
        $developmentMicroLoader = 'bootstrap.js',
        $productionManifest = 'bootstrap.json',
        $productionMicroLoader = 'bootstrap.js'
    ) {
        $this->builds[$name] = [
            'production'  => [
                'base'        => trim($productionBase, '/'),
                'manifest'    => $productionManifest,
                'microLoader' => $productionMicroLoader
            ],
            'development' => [
                'base'        => trim($developmentBase, '/'),
                'manifest'    => $developmentManifest,
                'microLoader' => $developmentMicroLoader
            ]
        ];
        if ($this->defaultBuild === null) {
            $this->defaultBuild = $name;
        }

        return $this;
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
     * @param bool $development
     * @return string
     */
    protected function getRootBaseUrl($development)
    {
        return $development ? $this->relativeWorkspaceUrl : $this->relativeWebUrl;
    }

    /**
     * @param bool $development
     * @return string
     */
    protected function getRootBasePath($development)
    {
        return $development ? $this->workspacePath : $this->webPath;
    }

    /**
     * @param string|null $name
     * @param string|null $key
     * @param bool        $development
     * @return string
     */
    protected function getFromBuild($name, $key, $development)
    {
        $build = $this->getBuild($name, $development);
        if ($key === null) {
            return $build['base'];
        } else {
            return $build['base'] . '/' . $build[$key];
        }
    }

    /**
     * @param string|null $name
     * @param bool        $development
     * @return string
     */
    public function getBasePath($name = null, $development = false)
    {
        return rtrim($this->getRootBasePath($development) . '/' . $this->getFromBuild($name, null, $development), '/');
    }

    /**
     * @param string|null $name
     * @param bool        $development
     * @return string
     */
    public function getRelativeBaseUrl($name = null, $development = false)
    {
        return trim($this->getRootBaseUrl($development) . '/' . $this->getFromBuild($name, null, $development), '/');
    }

    /**
     * @param string|null $name
     * @param bool        $development
     * @return string
     */
    public function getManifestPath($name = null, $development = false)
    {
        return $this->getRootBasePath($development) . '/' . $this->getFromBuild($name, 'manifest', $development);
    }

    /**
     * @param string|null $name
     * @param bool        $development
     * @return string
     */
    public function getMicroLoaderPath($name = null, $development = false)
    {
        return $this->getRootBasePath($development) . '/' . $this->getFromBuild($name, 'microLoader', $development);
    }

    /**
     * @return string|null
     */
    public function getDefaultBuild()
    {
        return $this->defaultBuild;
    }
}
