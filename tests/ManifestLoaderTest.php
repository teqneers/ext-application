<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 22.07.15
 * Time: 12:59
 */

namespace TQ\ExtJS\Application\Tests;

use TQ\ExtJS\Application\ManifestLoader;

/**
 * Class ManifestLoaderTest
 *
 * @package TQ\ExtJS\Application\Tests
 */
class ManifestLoaderTest extends \PHPUnit_Framework_TestCase
{

    public function testLoadDevelopmentManifest()
    {
        $loader   = new ManifestLoader();
        $manifest = $loader->loadManifest(
            '/path/to/app',
            new \SplFileInfo(__DIR__ . '/__workspace/my-app/manifest.json'),
            true
        );
        $this->assertInstanceOf('TQ\ExtJS\Application\Manifest', $manifest);
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/__files/ManifestLoaderTest/manifest.dev.json', (string)$manifest);
    }

    public function testLoadProductionManifest()
    {
        $loader   = new ManifestLoader();
        $manifest = $loader->loadManifest(
            '/path/to/app',
            new \SplFileInfo(__DIR__ . '/__htdocs/MyApp/manifest.json'),
            false
        );
        $this->assertInstanceOf('TQ\ExtJS\Application\Manifest', $manifest);
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/__files/ManifestLoaderTest/manifest.prod.json', (string)$manifest);
    }
}
