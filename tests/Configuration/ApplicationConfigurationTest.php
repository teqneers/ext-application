<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 22.07.15
 * Time: 12:26
 */

namespace TQ\ExtJS\Application\Tests\Configuration;


use TQ\ExtJS\Application\Configuration\ApplicationConfiguration;

/**
 * Class ApplicationConfigurationTest
 *
 * @package TQ\ExtJS\Application\Tests\Configuration
 */
class ApplicationConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDevelopmentBasePath()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals(__DIR__ . '/__files/workspace/my-app', $config->getBasePath(null, true));
    }

    public function testGetProductionBasePath()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals(__DIR__ . '/__files/htdocs/MyApp', $config->getBasePath(null, false));
    }

    public function testGetDevelopmentRelativeBaseUrl()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals('../workspace/my-app', $config->getRelativeBaseUrl(null, true));
    }

    public function testGetProductionRelativeBaseUrl()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals('MyApp', $config->getRelativeBaseUrl(null, false));
    }

    public function testGetDevelopmentManifestPath()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals(
            __DIR__ . '/__files/workspace/my-app/manifest.json',
            $config->getManifestPath(null, true)
        );
    }

    public function testGetProductionManifestPath()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals(
            __DIR__ . '/__files/htdocs/MyApp/manifest.json',
            $config->getManifestPath(null, false)
        );
    }

    public function testGetDevelopmentMicroLoaderPath()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals(
            __DIR__ . '/__files/workspace/my-app/bootstrap.js',
            $config->getMicroLoaderPath(null, true)
        );
    }

    public function testGetProductionMicroLoaderPath()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals(
            __DIR__ . '/__files/htdocs/MyApp/bootstrap.js',
            $config->getMicroLoaderPath(null, false)
        );
    }

    public function testGetDevelopmentAppCachePath()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertNull(
            $config->getAppCachePath(null, true)
        );
    }

    public function testGetProductionAppCachePath()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals(
            __DIR__ . '/__files/htdocs/MyApp/cache.appcache',
            $config->getAppCachePath(null, false)
        );
    }

    /**
     * @return ApplicationConfiguration
     */
    protected function createDefaultConfiguration()
    {
        $config = new ApplicationConfiguration(
            __DIR__ . '/__files/workspace',
            '../workspace',
            __DIR__ . '/__files/htdocs',
            '/'
        );

        $config->addBuild(
            'desktop',
            'my-app',
            'MyApp',
            'manifest.json',
            'bootstrap.js',
            null,
            'manifest.json',
            'bootstrap.js',
            'cache.appcache'
        );

        return $config;
    }

    public function testGetMultipleBuildConfiguration()
    {
        $config = new ApplicationConfiguration(
            __DIR__ . '/__files/workspace',
            '../workspace',
            __DIR__ . '/__files/htdocs',
            '/'
        );

        $this->assertNull($config->getDefaultBuild());

        $config->addBuild(
            'desktop',
            'my-app',
            'MyApp',
            'manifest.json',
            'bootstrap.js',

            'manifest.json',
            'bootstrap.js'
        );

        $config->addBuild(
            'desktop',
            'my-app',
            'desktop',
            'desktop.json',
            'bootstrap.js',
            null,
            'manifest.json',
            'bootstrap.js',
            'cache.appcache'
        )
               ->addBuild(
                   'tablet',
                   'my-app',
                   'tablet',
                   'tablet.json',
                   'bootstrap.js',
                   null,
                   'manifest.json',
                   'bootstrap.js',
                   'cache.appcache'
               );

        $this->assertEquals('desktop', $config->getDefaultBuild());

        $this->assertEquals('../workspace/my-app', $config->getRelativeBaseUrl('desktop', true));
        $this->assertEquals(
            __DIR__ . '/__files/workspace/my-app/desktop.json',
            $config->getManifestPath('desktop', true)
        );
        $this->assertEquals(
            __DIR__ . '/__files/workspace/my-app/bootstrap.js',
            $config->getMicroLoaderPath('desktop', true)
        );

        $this->assertEquals('desktop', $config->getRelativeBaseUrl('desktop', false));
        $this->assertEquals(
            __DIR__ . '/__files/htdocs/desktop/manifest.json',
            $config->getManifestPath('desktop', false)
        );
        $this->assertEquals(
            __DIR__ . '/__files/htdocs/desktop/bootstrap.js',
            $config->getMicroLoaderPath('desktop', false)
        );

        $this->assertEquals('../workspace/my-app', $config->getRelativeBaseUrl('tablet', true));
        $this->assertEquals(
            __DIR__ . '/__files/workspace/my-app/tablet.json',
            $config->getManifestPath('tablet', true)
        );
        $this->assertEquals(
            __DIR__ . '/__files/workspace/my-app/bootstrap.js',
            $config->getMicroLoaderPath('tablet', true)
        );

        $this->assertEquals('tablet', $config->getRelativeBaseUrl('tablet', false));
        $this->assertEquals(
            __DIR__ . '/__files/htdocs/tablet/manifest.json',
            $config->getManifestPath('tablet', false)
        );
        $this->assertEquals(
            __DIR__ . '/__files/htdocs/tablet/bootstrap.js',
            $config->getMicroLoaderPath('tablet', false)
        );

        $this->assertEquals('../workspace/my-app', $config->getRelativeBaseUrl(null, true));
        $this->assertEquals(
            __DIR__ . '/__files/workspace/my-app/desktop.json',
            $config->getManifestPath(null, true)
        );
        $this->assertEquals(
            __DIR__ . '/__files/workspace/my-app/bootstrap.js',
            $config->getMicroLoaderPath(null, true)
        );

        $this->assertEquals('desktop', $config->getRelativeBaseUrl(null, false));
        $this->assertEquals(
            __DIR__ . '/__files/htdocs/desktop/manifest.json',
            $config->getManifestPath(null, false)
        );
        $this->assertEquals(
            __DIR__ . '/__files/htdocs/desktop/bootstrap.js',
            $config->getMicroLoaderPath(null, false)
        );
    }
}
