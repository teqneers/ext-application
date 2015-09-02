<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 02.09.15
 * Time: 11:45
 */

namespace TQ\ExtJS\Application\Tests\Manifest;

use TQ\ExtJS\Application\Manifest\StaticPathMapper;

/**
 * Class StaticPathMapperTest
 *
 * @package TQ\ExtJS\Application\Tests\Manifest
 */
class StaticPathMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testAbsolutePath()
    {
        $pathMapper = new StaticPathMapper('/my/base/path');
        $this->assertEquals('/my/absolute/path', $pathMapper->mapPath('/my/absolute/path'));
    }

    public function testRelativePath()
    {
        $pathMapper = new StaticPathMapper('/my/base/path');
        $this->assertEquals('/my/base/path/my/relative/path', $pathMapper->mapPath('my/relative/path'));
    }
}
