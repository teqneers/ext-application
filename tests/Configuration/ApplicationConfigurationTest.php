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

        $this->assertEquals(__DIR__ . '/__files/MyApp/build/development/MyApp', $config->getBuildPath(null, true));
    }

    public function testGetProductionBasePath()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals(__DIR__ . '/__files/MyApp/build/production/MyApp', $config->getBuildPath(null, false));
    }

    public function testGetDevelopmentManifestPath()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals(
            __DIR__ . '/__files/MyApp/bootstrap.json',
            $config->getManifestPath(null, true)
        );
    }

    public function testGetProductionManifestPath()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals(
            __DIR__ . '/__files/MyApp/build/production/MyApp/app.json',
            $config->getManifestPath(null, false)
        );
    }

    public function testGetDevelopmentMicroLoaderPath()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals(
            __DIR__ . '/__files/MyApp/bootstrap.js',
            $config->getMicroLoaderPath(null, true)
        );
    }

    public function testGetProductionMicroLoaderPath()
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals(
            __DIR__ . '/__files/MyApp/build/production/MyApp/microloader.js',
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
            __DIR__ . '/__files/MyApp/build/production/MyApp/cache.appcache',
            $config->getAppCachePath(null, false)
        );
    }

    /**
     * @return ApplicationConfiguration
     */
    protected function createDefaultConfiguration()
    {
        $config = new ApplicationConfiguration(
            __DIR__ . '/__files/MyApp'
        );

        $config->addBuild(
            'desktop',
            [
                'build_path'  => 'build/development/MyApp',
                'microloader' => '/bootstrap.js',
                'manifest'    => '/bootstrap.json',
                'app_cache'   => null,
            ],
            [
                'build_path'  => 'build/production/MyApp',
                'microloader' => 'microloader.js',
                'manifest'    => 'app.json',
                'app_cache'   => 'cache.appcache',
            ]
        );

        return $config;
    }

    public function testGetMultipleBuildConfiguration()
    {
        $config = new ApplicationConfiguration(
            __DIR__ . '/__files/MyApp'
        );

        $this->assertNull($config->getDefaultBuild());

        $config->addBuild(
            'desktop',
            [
                'build_path'  => 'build/development/desktop/MyApp',
                'microloader' => '/bootstrap.js',
                'manifest'    => '/desktop.json',
                'app_cache'   => null,
            ],
            [
                'build_path'  => 'build/production/desktop/MyApp',
                'microloader' => 'microloader.js',
                'manifest'    => 'app.json',
                'app_cache'   => 'cache.appcache',
            ]
        )
               ->addBuild(
                   'tablet',
                   [
                       'build_path'  => 'build/development/tablet/MyApp',
                       'microloader' => '/bootstrap.js',
                       'manifest'    => '/tablet.json',
                       'app_cache'   => null,
                   ],
                   [
                       'build_path'  => 'build/production/tablet/MyApp',
                       'microloader' => 'microloader.js',
                       'manifest'    => 'app.json',
                       'app_cache'   => 'cache.appcache',
                   ]
               );

        $this->assertEquals('desktop', $config->getDefaultBuild());

        $this->assertEquals(
            __DIR__ . '/__files/MyApp/desktop.json',
            $config->getManifestPath('desktop', true)
        );
        $this->assertEquals(
            __DIR__ . '/__files/MyApp/bootstrap.js',
            $config->getMicroLoaderPath('desktop', true)
        );

        $this->assertEquals(
            __DIR__ . '/__files/MyApp/build/production/desktop/MyApp/app.json',
            $config->getManifestPath('desktop', false)
        );
        $this->assertEquals(
            __DIR__ . '/__files/MyApp/build/production/desktop/MyApp/microloader.js',
            $config->getMicroLoaderPath('desktop', false)
        );

        $this->assertEquals(
            __DIR__ . '/__files/MyApp/tablet.json',
            $config->getManifestPath('tablet', true)
        );
        $this->assertEquals(
           __DIR__ . '/__files/MyApp/bootstrap.js',
            $config->getMicroLoaderPath('tablet', true)
        );

        $this->assertEquals(
            __DIR__ . '/__files/MyApp/build/production/tablet/MyApp/app.json',
            $config->getManifestPath('tablet', false)
        );
        $this->assertEquals(
            __DIR__ . '/__files/MyApp/build/production/tablet/MyApp/microloader.js',
            $config->getMicroLoaderPath('tablet', false)
        );

        $this->assertEquals(
            __DIR__ . '/__files/MyApp/desktop.json',
            $config->getManifestPath(null, true)
        );
        $this->assertEquals(
             __DIR__ . '/__files/MyApp/bootstrap.js',
            $config->getMicroLoaderPath(null, true)
        );

        $this->assertEquals(
            __DIR__ . '/__files/MyApp/build/production/desktop/MyApp/app.json',
            $config->getManifestPath(null, false)
        );
        $this->assertEquals(
            __DIR__ . '/__files/MyApp/build/production/desktop/MyApp/microloader.js',
            $config->getMicroLoaderPath(null, false)
        );
    }
}
