<?php

declare(strict_types=1);

namespace Zing\Yii2PsrSimpleCache\Tests;

use Zing\Yii2PsrSimpleCache\DynamicCache;

/**
 * @internal
 */
final class DynamicCacheTest extends TestCase
{
    public function testCacheUsesCurrent(): void
    {
        \defined('YII_ENABLE_ERROR_HANDLER') || \define('YII_ENABLE_ERROR_HANDLER', false);
        $this->mockApplication();
        $mockObject = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject->expects($this->once())
            ->method('get')
            ->with('test1');

        $mockObject2 = $this->getMockBuilder('yii\caching\CacheInterface')
            ->getMock();
        $mockObject2->expects($this->once())
            ->method('get')
            ->with('test2');

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);

        $dynamicCache->get('test1');

        \Yii::$app->setComponents([
            'cache' => $mockObject2,
        ]);
        $dynamicCache->get('test2');
    }

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

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);
        $this->assertSame(2, $dynamicCache->get('test', 1));
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

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);
        $this->assertNull($dynamicCache->get('test'));
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

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);
        $this->assertSame(1, $dynamicCache->get('test', 1));
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

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);

        $this->assertTrue($dynamicCache->set('test', 'value', 1));
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

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);

        $this->assertTrue($dynamicCache->set('test', 'value', new \DateInterval('PT1S')));
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

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);

        $this->assertTrue($dynamicCache->set('test', 'value'));
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

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);

        $this->assertTrue($dynamicCache->set('test', 'value', -1));
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
        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);

        $this->assertTrue($dynamicCache->delete('test'));
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
        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);

        $this->assertTrue($dynamicCache->clear());
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

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);

        $this->assertSame([
            'test1' => 2,
            'test2' => null,
        ], $dynamicCache->getMultiple(['test1', 'test2']));
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

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);

        $this->assertSame([
            'test1' => 2,
            'test2' => 1,
        ], $dynamicCache->getMultiple(['test1', 'test2'], 1));
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

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);

        $this->assertTrue($dynamicCache->setMultiple([
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

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);

        $this->assertTrue($dynamicCache->setMultiple([
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

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);

        $this->assertTrue($dynamicCache->setMultiple([
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

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);

        $this->assertTrue($dynamicCache->setMultiple([
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
        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);

        $this->assertTrue($dynamicCache->deleteMultiple(['test1', 'test2', 'test3']));
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
        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);

        $this->assertFalse($dynamicCache->deleteMultiple(['test1', 'test2', 'test3']));
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

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);
        $this->assertTrue($dynamicCache->has('test'));
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

        $dynamicCache = new DynamicCache();
        \Yii::$app->setComponents([
            'cache' => $mockObject,
        ]);
        $this->assertFalse($dynamicCache->has('test'));
    }
}
