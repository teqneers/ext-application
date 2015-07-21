<?php
/**
 * teqneers/ext-application
 *
 * @category   TQ
 * @package    TQ\ExtJS\Application
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace TQ\ExtJS\Application;

use TQ\ExtJS\Application\Exception\FileNotFoundException;

/**
 * Class Application
 *
 * @package TQ\ExtJS\Application
 */
class Application
{
    /**
     * @var ApplicationConfiguration
     */
    private $configuration;

    /**
     * @var ManifestLoader
     */
    protected $manifestLoader;

    /**
     * @var string
     */
    protected $environment;

    /**
     * @param ApplicationConfiguration $configuration
     * @param ManifestLoader           $manifestLoader
     * @param string                   $environment
     */
    public function __construct(
        ApplicationConfiguration $configuration,
        ManifestLoader $manifestLoader,
        $environment = 'prod'
    ) {
        $this->configuration  = $configuration;
        $this->manifestLoader = $manifestLoader;
        $this->environment    = $environment;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->configuration->getName();
    }

    /**
     * @return bool
     */
    public function isDevelopment()
    {
        return $this->environment == 'dev';
    }

    /**
     * @return string
     */
    public function getApplicationPath()
    {
        if ($this->isDevelopment()) {
            return $this->configuration->getApplicationDevelopmentPath();
        } else {
            return $this->configuration->getApplicationProductionPath();
        }
    }

    /**
     * @return \SplFileInfo
     */
    public function getMicroLoaderFile()
    {
        return $this->getApplicationFile($this->configuration->getBootstrapName());
    }

    /**
     * @return \SplFileInfo
     */
    protected function getManifestFile()
    {
        return $this->getApplicationFile($this->configuration->getManifestName());
    }

    /**
     * @param string $path
     * @return \SplFileInfo
     */
    protected function getApplicationFile($path)
    {
        $path = $this->getApplicationPath() . '/' . $path;
        if (!file_exists($path) || !is_readable($path)) {
            throw new FileNotFoundException($path);
        }
        return new \SplFileInfo($path);
    }

    /**
     * @param string $basePath
     * @return Manifest
     */
    public function getManifest($basePath)
    {
        $basePath = rtrim($basePath, '/');
        if ($this->isDevelopment()) {
            $basePath .= '/' . $this->configuration->getApplicationDevelopmentUrl();
        } else {
            $basePath .= '/' . $this->configuration->getApplicationProductionUrl();
        }

        return $this->manifestLoader->loadManifest($basePath, $this->getManifestFile(), $this->isDevelopment());
    }
}
