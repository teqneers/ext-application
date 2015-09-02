<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 22.07.15
 * Time: 14:01
 */

namespace TQ\ExtJS\Application\Tests;

use TQ\ExtJS\Application\Application;
use TQ\ExtJS\Application\Configuration\ApplicationConfiguration;
use TQ\ExtJS\Application\Manifest\Manifest;
use TQ\ExtJS\Application\Manifest\ManifestLoader;

/**
 * Class ApplicationTest
 *
 * @package TQ\ExtJS\Application\Tests
 */
class ApplicationTest extends \PHPUnit_Framework_TestCase
{

    public function testProdIsNotDevelopment()
    {
        $app = $this->createDefaultApplication('prod');

        $this->assertFalse($app->isDevelopment());
    }

    public function testDevIsDevelopment()
    {
        $app = $this->createDefaultApplication('dev');

        $this->assertTrue($app->isDevelopment());
    }

    public function testDevBasePath()
    {
        $app = $this->createDefaultApplication('dev');
        $this->assertEquals(__DIR__ . '/__files/workspace/my-app/../build/development/MyApp', $app->getBuildPath());
    }

    public function testProdBasePath()
    {
        $app = $this->createDefaultApplication('prod');
        $this->assertEquals(__DIR__ . '/__files/workspace/my-app/../build/production/MyApp', $app->getBuildPath());
    }

    public function testDevMicroLoaderFile()
    {
        $app = $this->createDefaultApplication('dev');
        $this->assertEquals(
            __DIR__ . '/__files/workspace/my-app/bootstrap.js',
            $app->getMicroLoaderFile()
                ->getPathname()
        );
    }

    public function testProdMicroLoaderFile()
    {
        $app = $this->createDefaultApplication('prod');
        $this->assertEquals(
            __DIR__ . '/__files/workspace/my-app/../build/production/MyApp/microloader.js',
            $app->getMicroLoaderFile()
                ->getPathname()
        );
    }

    public function testDevManifest()
    {
        $loader = $this->createManifestLoaderMock();

        $loader->expects($this->once())
               ->method('loadManifest')
               ->with(
                   $this->isInstanceOf('SplFileInfo'),
                   $this->equalTo('desktop'),
                   $this->equalTo(true)
               )
               ->willReturn(new Manifest(__DIR__ . '/__files/workspace/my-app/bootstrap.json', array()));

        $app = new Application(
            $this->createDefaultConfiguration(),
            $loader,
            'dev'
        );

        $this->assertInstanceOf('TQ\ExtJS\Application\Manifest\Manifest', $app->getManifest());
    }

    public function testProdManifest()
    {
        $loader = $this->createManifestLoaderMock();

        $loader->expects($this->once())
               ->method('loadManifest')
               ->with(
                   $this->isInstanceOf('SplFileInfo'),
                   $this->equalTo('desktop'),
                   $this->equalTo(false)
               )
               ->willReturn(new Manifest(__DIR__ . '__files/workspace/build/production/MyApp/app.json', array()));

        $app = new Application(
            $this->createDefaultConfiguration(),
            $loader,
            'prod'
        );

        $this->assertInstanceOf('TQ\ExtJS\Application\Manifest\Manifest', $app->getManifest());
    }

    public function testDevAppCacheFile()
    {
        $app = $this->createDefaultApplication('dev');

        $this->assertFalse($app->hasAppCache());

        $this->setExpectedException('TQ\ExtJS\Application\Exception\FileNotFoundException', 'File "" not found');
        $this->assertNull($app->getAppCacheFile());
    }

    public function testProdAppCacheFile()
    {
        $app = $this->createDefaultApplication('prod');

        $this->assertTrue($app->hasAppCache());

        $this->assertEquals(
            __DIR__ . '/__files/workspace/my-app/../build/production/MyApp/cache.appcache',
            $app->getAppCacheFile()
                ->getPathname()
        );
    }

    public function testGetApplicationIdInDevelopment()
    {
        $app = $this->createDefaultApplication('dev');

        $this->assertEquals('7381d97d-f4e9-44ef-aa2e-097045dfb87a', $app->getApplicationId());
    }

    public function testGetApplicationIdInProduction()
    {
        $app = $this->createDefaultApplication('prod');

        $this->assertEquals('7381d97d-f4e9-44ef-aa2e-097045dfb87a', $app->getApplicationId());
    }

    /**
     * @param string $environment
     * @return Application
     */
    protected function createDefaultApplication($environment)
    {
        return new Application(
            $this->createDefaultConfiguration(),
            $this->createManifestLoaderMock(),
            $environment
        );
    }

    /**
     * @return ManifestLoader|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createManifestLoaderMock()
    {
        return $this->getMock(
            'TQ\ExtJS\Application\Manifest\ManifestLoader',
            array('loadManifest'),
            array(),
            '',
            false
        );
    }

    /**
     * @return ApplicationConfiguration
     */
    protected function createDefaultConfiguration()
    {
        $config = new ApplicationConfiguration(
            __DIR__ . '/__files/workspace/my-app'
        );

        $config->addBuild(
            'desktop',
            [
                'build_path'  => '../build/development/MyApp',
                'microloader' => '/bootstrap.js',
                'manifest'    => '/bootstrap.json',
                'app_cache'   => null,
            ],
            [
                'build_path'  => '../build/production/MyApp',
                'microloader' => 'microloader.js',
                'manifest'    => 'app.json',
                'app_cache'   => 'cache.appcache',
            ]
        );

        return $config;
    }
}
