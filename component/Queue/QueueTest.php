<?php

namespace Neoan3\Component\Queue;

use PHPUnit\Framework\TestCase;

/**
 * Class PostTest
 * Generated by neoan3-cli
 * @package Neoan3\Component\Queue
 */
class QueueTest extends TestCase
{
    private QueueController $instance;
    function setUp(): void
    {
        $this->instance = new QueueController();
    }
    
    function testGetQueue()
    {
        $response = $this->instance->getQueue('03c5', ['feae'=>'babd0b']);
        $this->assertIsArray($response);
        $this->assertSame(['feae'=>'babd0b'], $response);
    }

    function testPostQueue()
    {
        $response = $this->instance->postQueue(['125f'=>'5f0732']);
        $this->assertIsArray($response);
        $this->assertSame(['125f'=>'5f0732'], $response);
    }

}
