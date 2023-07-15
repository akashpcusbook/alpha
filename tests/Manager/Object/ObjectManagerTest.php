<?php

namespace Tusker\Framework\Tests\Manager\Object;

use PHPUnit\Framework\TestCase;
use Tusker\Framework\Manager\Object\ObjectManager;

class ObjectManagerTest extends TestCase
{
    public function testGetInstanceTest(): void
    {
        $objectManager = ObjectManager::getInstance();
        
        $this->assertSame($objectManager, getObjectManager());
    }
}
