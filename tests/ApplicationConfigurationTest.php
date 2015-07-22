<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 22.07.15
 * Time: 12:26
 */

namespace TQ\ExtJS\Application\Tests;


use TQ\ExtJS\Application\ApplicationConfiguration;

/**
 * Class ApplicationConfigurationTest
 *
 * @package TQ\ExtJS\Application\Tests
 */
class ApplicationConfigurationTest extends \PHPUnit_Framework_TestCase
{

    public function testApplicationDevelopmentPath()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals(__DIR__ . '/___workspace/my-app', $config->getApplicationDevelopmentPath());
    }

    public function testApplicationProductionPath()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals(__DIR__ . '/__htdocs/MyApp', $config->getApplicationProductionPath());
    }

    public function testApplicationDevelopmentUrl()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals('../workspace/my-app', $config->getApplicationDevelopmentUrl());
    }

    public function testApplicationProductionUrl()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals('MyApp', $config->getApplicationProductionUrl());
    }

    /**
     * @return ApplicationConfiguration
     */
    protected function createDefaultConfiguration()
    {
        $config = new ApplicationConfiguration(
            'my-app',
            'MyApp',
            '../workspace',
            __DIR__ . '/___workspace',
            __DIR__ . '/__htdocs',
            'bootstrap.js',
            'manifest.json'
        );
        return $config;
    }
}
