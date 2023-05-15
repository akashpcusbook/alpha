<?php

namespace App\Tests;

use App\Tusker\Parsers\EnvParser;
use PHPUnit\Framework\TestCase;

class EnvParserTest extends TestCase
{
    public function testEnvParser(): void
    {
        new EnvParser();
        $this->assertSame('abc123', $_ENV['SECRET_KEY']);
        $this->assertSame('devbucket', $_SERVER['S3_BUCKET']);
    }
}
