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

    public function testDevMicroLoaderFile()
    {
        $app = $this->createDefaultApplication('dev');
        $this->assertEquals(__DIR__ . '/__files/workspace/my-app/bootstrap.js', $app->getMicroLoaderFile()
                                                                                    ->getPathname());
    }

    public function testProdMicroLoaderFile()
    {
        $app = $this->createDefaultApplication('prod');
        $this->assertEquals(__DIR__ . '/__files/htdocs/MyApp/bootstrap.js', $app->getMicroLoaderFile()
                                                                                ->getPathname());
    }

    public function testDevManifest()
    {
        $loader = $this->createManifestLoaderMock();

        $loader->expects($this->once())
               ->method('loadManifest')
               ->with(
                   $this->equalTo('/path/to/app/../workspace/my-app'),
                   $this->isInstanceOf('SplFileInfo'),
                   $this->equalTo(true)
               )
               ->willReturn(new Manifest(array()));

        $app = new Application(
            $this->createDefaultConfiguration(),
            $loader,
            'dev'
        );

        $this->assertInstanceOf('TQ\ExtJS\Application\Manifest\Manifest', $app->getManifest('/path/to/app'));
    }

    public function testProdManifest()
    {
        $loader = $this->createManifestLoaderMock();

        $loader->expects($this->once())
               ->method('loadManifest')
               ->with(
                   $this->equalTo('/path/to/app/MyApp'),
                   $this->isInstanceOf('SplFileInfo'),
                   $this->equalTo(false)
               )
               ->willReturn(new Manifest(array()));

        $app = new Application(
            $this->createDefaultConfiguration(),
            $loader,
            'prod'
        );

        $this->assertInstanceOf('TQ\ExtJS\Application\Manifest\Manifest', $app->getManifest('/path/to/app'));
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
        return $this->getMock('TQ\ExtJS\Application\Manifest\ManifestLoader', array('loadManifest'));
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
            'manifest.json',
            'bootstrap.js'
        );

        return $config;
    }
}
