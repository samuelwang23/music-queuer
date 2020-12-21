<?php

namespace Neoan3\Component\Album;

use PHPUnit\Framework\TestCase;

/**
 * Class PostTest
 * Generated by neoan3-cli
 * @package Neoan3\Component\Album
 */
class AlbumTest extends TestCase
{
    private AlbumController $instance;
    function setUp(): void
    {
        $this->instance = new AlbumController();
    }
    
    function testGetAlbum()
    {
        $response = $this->instance->getAlbum('16c2', ['6408'=>'527204']);
        $this->assertIsArray($response);
        $this->assertSame(['6408'=>'527204'], $response);
    }

    function testPostAlbum()
    {
        $response = $this->instance->postAlbum(['41a0'=>'22b943']);
        $this->assertIsArray($response);
        $this->assertSame(['41a0'=>'22b943'], $response);
    }

}