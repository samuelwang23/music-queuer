<?php

namespace Neoan3\Model\Artist;

use Neoan3\Provider\MySql\Database;
use Neoan3\Provider\MySql\MockDatabaseWrapper;
use PHPUnit\Framework\TestCase;

/**
 * Class PostTest
 * @package Neoan3\Model
 */
class ArtistTest extends TestCase
{
    /**
     * @var Database|MockDatabaseWrapper
     */
    private Database $mockDb;


    function setUp(): void
    {
        $this->mockDb = new MockDatabaseWrapper(['name'=>'test']);

    }


    /**
     * Test retrieval
     */
    public function testGet()
    {
        $model = $this->mockDb->mockGet('artist');
        ArtistModel::init(['db'=>$this->mockDb]);
        $res = ArtistModel::get($model['id']);
        $this->assertIsArray($res);
        $this->assertSame($model, $res);
    }

    /**
     * Test update
     */
    public function testUpdate()
    {
        $model = $this->mockDb->mockModel('artist');
        $model[array_keys($model)[0]] = 'abc';
        $this->mockDb->mockUpdate('artist', $model);
        ArtistModel::init(['db'=>$this->mockDb]);
        $result = ArtistModel::update($model);
        $this->assertSame($result[array_keys($model)[0]], 'abc');
    }

    /**
     * Test creation
     */
    public function testCreate()
    {
        $model = $this->mockDb->mockModel('artist');
        $this->mockDb->registerResult([['id' => '123456789']]);
        $inserted = $this->mockDb->mockUpdate('artist', $model);
        ArtistModel::init(['db'=>$this->mockDb]);
        $created = ArtistModel::create($model);
        $this->assertSame($inserted, $created);
    }

}
