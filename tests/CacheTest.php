<?php

declare(strict_types=1);

namespace Zing\Yii2PsrSimpleCache\Tests;

use Zing\Yii2PsrSimpleCache\Cache;

/**
 * @internal
 */
final class CacheTest extends TestCase
{
    public function testGet(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('get')
            ->with('test')
            ->willReturn(2);

        $cache = new Cache($mockObject);
        $this->assertSame(2, $cache->get('test', 1));
    }

    public function testGetWithoutDefault(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('get')
            ->with('test')
            ->willReturn(false);

        $cache = new Cache($mockObject);
        $this->assertNull($cache->get('test'));
    }

    public function testGetWithDefault(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('get')
            ->with('test')
            ->willReturn(false);

        $cache = new Cache($mockObject);
        $this->assertSame(1, $cache->get('test', 1));
    }

    public function testSet(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('set')
            ->with('test', 'value', 1)
            ->willReturn(true);

        $cache = new Cache($mockObject);

        $this->assertTrue($cache->set('test', 'value', 1));
    }

    public function testSetWithDateInterval(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('set')
            ->with('test', 'value', 1)
            ->willReturn(true);

        $cache = new Cache($mockObject);

        $this->assertTrue($cache->set('test', 'value', new \DateInterval('PT1S')));
    }

    public function testSetWithoutTtlValue(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('set')
            ->with('test', 'value', 0)
            ->willReturn(true, true);

        $cache = new Cache($mockObject);

        $this->assertTrue($cache->set('test', 'value'));
    }

    public function testSetWithNegativeTtl(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('delete')
            ->with('test')
            ->willReturn(true);

        $cache = new Cache($mockObject);

        $this->assertTrue($cache->set('test', 'value', -1));
    }

    public function testDelete(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('delete')
            ->with('test')
            ->willReturn(true);
        $cache = new Cache($mockObject);

        $this->assertTrue($cache->delete('test'));
    }

    public function testClear(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('flush')
            ->willReturn(true);
        $cache = new Cache($mockObject);

        $this->assertTrue($cache->clear());
    }

    public function testGetMultiple(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('multiGet')
            ->with(['test1', 'test2'])
            ->willReturn([
                'test1' => 2,
                'test2' => false,
            ]);

        $cache = new Cache($mockObject);

        $this->assertSame([
            'test1' => 2,
            'test2' => null,
        ], $cache->getMultiple(['test1', 'test2']));
    }

    public function testGetMultipleWithDefault(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('multiGet')
            ->with(['test1', 'test2'])
            ->willReturn([
                'test1' => 2,
                'test2' => false,
            ]);

        $cache = new Cache($mockObject);

        $this->assertSame([
            'test1' => 2,
            'test2' => 1,
        ], $cache->getMultiple(['test1', 'test2'], 1));
    }

    public function testSetMultiple(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('multiSet')
            ->with([
                'test' => 'value',
            ], 1, null)
            ->willReturn([]);

        $cache = new Cache($mockObject);

        $this->assertTrue($cache->setMultiple([
            'test' => 'value',
        ], 1));
    }

    public function testSetMultipleWithDateInterval(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('multiSet')
            ->with([
                'test' => 'value',
            ], 1, null)
            ->willReturn([]);

        $cache = new Cache($mockObject);

        $this->assertTrue($cache->setMultiple([
            'test' => 'value',
        ], new \DateInterval('PT1S')));
    }

    public function testSetMultipleWithoutTtlValue(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('multiSet')
            ->with([
                'test' => 'value',
            ], 0, null)
            ->willReturn([], []);

        $cache = new Cache($mockObject);

        $this->assertTrue($cache->setMultiple([
            'test' => 'value',
        ]));
    }

    public function testSetMultipleWithNegativeTtl(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('delete')
            ->with('test')
            ->willReturn(true);

        $cache = new Cache($mockObject);

        $this->assertTrue($cache->setMultiple([
            'test' => 'value',
        ], -1));
    }

    public function testDeleteMultiple(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->exactly(3))
            ->method('delete')
            ->withAnyParameters()
            ->willReturn(true);
        $cache = new Cache($mockObject);

        $this->assertTrue($cache->deleteMultiple(['test1', 'test2', 'test3']));
    }

    public function testDeleteMultipleFailed(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->exactly(3))
            ->method('delete')
            ->withAnyParameters()
            ->willReturn(false, false, false);
        $cache = new Cache($mockObject);

        $this->assertFalse($cache->deleteMultiple(['test1', 'test2', 'test3']));
    }

    public function testHas(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('exists')
            ->with('test')
            ->willReturn(true);

        $cache = new Cache($mockObject);
        $this->assertTrue($cache->has('test'));
    }

    public function testHasReturnFalse(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('exists')
            ->with('test')
            ->willReturn(false);

        $cache = new Cache($mockObject);
        $this->assertFalse($cache->has('test'));
    }

    public function testCreateWithoutCacheComponent(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        if (method_exists($this, 'expectException')) {
            $this->expectException('InvalidArgumentException');
        } else {
            $this->setExpectedException('InvalidArgumentException');
        }

        new Cache();
    }
}
