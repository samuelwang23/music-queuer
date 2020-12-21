<?php

namespace Neoan3\Component\Artist;

use PHPUnit\Framework\TestCase;

/**
 * Class PostTest
 * Generated by neoan3-cli
 * @package Neoan3\Component\Artist
 */
class ArtistTest extends TestCase
{
    private ArtistController $instance;
    function setUp(): void
    {
        $this->instance = new ArtistController();
    }
    
    function testGetArtist()
    {
        $response = $this->instance->getArtist('4b8b', ['1eac'=>'680756']);
        $this->assertIsArray($response);
        $this->assertSame(['1eac'=>'680756'], $response);
    }

    function testPostArtist()
    {
        $response = $this->instance->postArtist(['3bac'=>'10fc8a']);
        $this->assertIsArray($response);
        $this->assertSame(['3bac'=>'10fc8a'], $response);
    }

}
