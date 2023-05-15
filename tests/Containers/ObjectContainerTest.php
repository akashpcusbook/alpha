<?php

namespace App\Tests\Containers;

use App\Tusker\Containers\ObjectContainer;
use PHPUnit\Framework\TestCase;

class ObjectContainerTest extends TestCase
{
    public function testRegister(): void
    {
        $objectContainer = new ObjectContainer();
        $objectContainer->register('testClass', TestClass::class);
        $this->assertInstanceOf(TestClass::class, $objectContainer->getObject('testClass'));
    }
}
