<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 22.07.15
 * Time: 12:59
 */

namespace TQ\ExtJS\Application\Tests\Manifest;

use PHPUnit\Framework\TestCase;
use TQ\ExtJS\Application\Manifest\ManifestLoader;
use TQ\ExtJS\Application\Manifest\StaticPathMapper;

/**
 * Class ManifestLoaderTest
 *
 * @package TQ\ExtJS\Application\Tests\Manifest
 */
class ManifestLoaderTest extends TestCase
{

    public function testLoadDevelopmentManifest()
    {
        $loader   = new ManifestLoader(new StaticPathMapper('/path/to/app/'));
        $manifest = $loader->loadManifest(
            new \SplFileInfo(__DIR__ . '/__files/manifest.dev.json'),
            'default',
            true
        );
        $this->assertInstanceOf('TQ\ExtJS\Application\Manifest\Manifest', $manifest);
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/__files/manifest.dev.expected.json',
            (string)$manifest);
    }

    public function testLoadProductionManifest()
    {
        $loader   = new ManifestLoader(new StaticPathMapper('/path/to/app/'));
        $manifest = $loader->loadManifest(
            new \SplFileInfo(__DIR__ . '/__files/manifest.prod.json'),
            'default',
            false
        );
        $this->assertInstanceOf('TQ\ExtJS\Application\Manifest\Manifest', $manifest);
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/__files/manifest.prod.expected.json',
            (string)$manifest);
    }
}
