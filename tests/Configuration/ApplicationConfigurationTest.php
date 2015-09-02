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
     * @dataProvider developmentBuildArtifactPathProvider
     * @param string $path
     * @param string $expected
     */
    public function testGetDevelopmentBuildArtifactPath($path, $expected)
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals($expected, $config->getBuildArtifactPath($path, null, true));
    }

    /**
     * @return array
     */
    public function developmentBuildArtifactPathProvider()
    {
        return array(
            array(
                'build/development/MyApp/resources/MyApp-all_1.css',
                __DIR__ . '/__files/MyApp/build/development/MyApp/resources/MyApp-all_1.css'
            ),
            array(
                'build/development/MyApp/resources/MyApp-all_2.css',
                __DIR__ . '/__files/MyApp/build/development/MyApp/resources/MyApp-all_2.css'
            ),
            array(
                'ext/build/ext-all-rtl-debug.js',
                __DIR__ . '/__files/MyApp/ext/build/ext-all-rtl-debug.js'
            ),
            array(
                'app/Application.js',
                __DIR__ . '/__files/MyApp/app/Application.js'
            ),
            array(
                'app.js',
                __DIR__ . '/__files/MyApp/app.js'
            ),
            array(
                'build/development/MyApp/resources/fonts/OpenSans-Regular.ttf',
                __DIR__ . '/__files/MyApp/build/development/MyApp/resources/fonts/OpenSans-Regular.ttf'
            ),
            array(
                'build/development/MyApp/resources/ext-watermark/fonts/ext-watermark.woff',
                __DIR__ . '/__files/MyApp/build/development/MyApp/resources/ext/ext-watermark/fonts/ext-watermark.woff'
            )
        );
    }

    /**
     * @dataProvider productionBuildArtifactPathProvider
     * @param string $path
     * @param string $expected
     */
    public function testGetProductionBuildArtifactPath($path, $expected)
    {
        $config = $this->createDefaultConfiguration();

        $this->assertEquals($expected, $config->getBuildArtifactPath($path, null, false));
    }

    /**
     * @return array
     */
    public function productionBuildArtifactPathProvider()
    {
        return array(
            array(
                'resources/MyApp-all_1.css',
                __DIR__ . '/__files/MyApp/build/production/MyApp/resources/MyApp-all_1.css'
            ),
            array(
                'resources/MyApp-all_2.css',
                __DIR__ . '/__files/MyApp/build/production/MyApp/resources/MyApp-all_2.css'
            ),
            array(
                'app.js',
                __DIR__ . '/__files/MyApp/build/production/MyApp/app.js'
            ),
            array(
                'resources/fonts/OpenSans-Regular.ttf',
                __DIR__ . '/__files/MyApp/build/production/MyApp/resources/fonts/OpenSans-Regular.ttf'
            ),
            array(
                'resources/ext-watermark/fonts/ext-watermark.woff',
                __DIR__ . '/__files/MyApp/build/production/MyApp/resources/ext/ext-watermark/fonts/ext-watermark.woff'
            )
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
