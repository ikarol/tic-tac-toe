<?php
declare(strict_types = 1);
use PHPUnit\Framework\TestCase;
use API\HttpHandler;

final class HttpHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function on_handler_creation()
    {
        $handler = new HttpHandler();
        $this->assertInstanceOf(HttpHandler::class, $handler);
    }
}
