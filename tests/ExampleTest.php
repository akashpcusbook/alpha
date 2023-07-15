<?php

namespace Tusker\Framework\Tests;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testGreetsWithName(): void
    {
        $greeting = 'Hello World';

        $this->assertSame('Hello World', $greeting);
    }
}
