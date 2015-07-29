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
    protected $name;

    /**
     * @var string
     */
    protected $relativeUrl;

    /**
     * @var string
     */
    protected $relativeWorkspaceUrl;

    /**
     * @var string
     */
    protected $workspacePath;

    /**
     * @var string
     */
    protected $webPath;

    /**
     * @var string
     */
    protected $bootstrapName;

    /**
     * @var string
     */
    protected $manifestName;

    /**
     * @param string $name
     * @param string $relativeUrl
     * @param string $relativeWorkspaceUrl
     * @param string $workspacePath
     * @param string $webPath
     * @param string $bootstrapName
     * @param string $manifestName
     */
    public function __construct(
        $name,
        $relativeUrl,
        $relativeWorkspaceUrl,
        $workspacePath,
        $webPath,
        $bootstrapName,
        $manifestName
    ) {
        $this->name                 = $name;
        $this->relativeUrl          = $relativeUrl;
        $this->relativeWorkspaceUrl = $relativeWorkspaceUrl;
        $this->workspacePath        = $workspacePath;
        $this->webPath              = $webPath;
        $this->bootstrapName        = $bootstrapName;
        $this->manifestName         = $manifestName;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getApplicationDevelopmentPath()
    {
        return $this->workspacePath . '/' . $this->getName();
    }

    /**
     * @return string
     */
    public function getApplicationProductionPath()
    {
        return $this->webPath . '/' . $this->relativeUrl;
    }

    /**
     * @return string
     */
    public function getApplicationDevelopmentUrl()
    {
        return $this->relativeWorkspaceUrl . '/' . $this->getName();
    }

    /**
     * @return string
     */
    public function getApplicationProductionUrl()
    {
        return $this->relativeUrl;
    }

    /**
     * @return string
     */
    public function getBootstrapName()
    {
        return $this->bootstrapName;
    }

    /**
     * @return string
     */
    public function getManifestName()
    {
        return $this->manifestName;
    }
}
