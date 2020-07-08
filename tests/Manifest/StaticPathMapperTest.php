<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 02.09.15
 * Time: 11:45
 */

namespace TQ\ExtJS\Application\Tests\Manifest;

use PHPUnit\Framework\TestCase;
use TQ\ExtJS\Application\Manifest\StaticPathMapper;

/**
 * Class StaticPathMapperTest
 *
 * @package TQ\ExtJS\Application\Tests\Manifest
 */
class StaticPathMapperTest extends TestCase
{
    public function testAbsolutePath()
    {
        $pathMapper = new StaticPathMapper('/my/base/path');
        $this->assertEquals(
            '/my/absolute/path',
            $pathMapper->mapPath('/my/absolute/path', 'default', false)
        );
    }

    public function testRelativePath()
    {
        $pathMapper = new StaticPathMapper('/my/base/path');
        $this->assertEquals(
            '/my/base/path/my/relative/path',
            $pathMapper->mapPath('my/relative/path', 'default', false)
        );
    }
}
