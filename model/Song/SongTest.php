<?php

namespace Neoan3\Model\Song;

use Neoan3\Provider\MySql\Database;
use Neoan3\Provider\MySql\MockDatabaseWrapper;
use PHPUnit\Framework\TestCase;

/**
 * Class PostTest
 * @package Neoan3\Model
 */
class SongTest extends TestCase
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
        $model = $this->mockDb->mockGet('song');
        SongModel::init(['db'=>$this->mockDb]);
        $res = SongModel::get($model['id']);
        $this->assertIsArray($res);
        $this->assertSame($model, $res);
    }

    /**
     * Test update
     */
    public function testUpdate()
    {
        $model = $this->mockDb->mockModel('song');
        $model[array_keys($model)[0]] = 'abc';
        $this->mockDb->mockUpdate('song', $model);
        SongModel::init(['db'=>$this->mockDb]);
        $result = SongModel::update($model);
        $this->assertSame($result[array_keys($model)[0]], 'abc');
    }

    /**
     * Test creation
     */
    public function testCreate()
    {
        $model = $this->mockDb->mockModel('song');
        $this->mockDb->registerResult([['id' => '123456789']]);
        $inserted = $this->mockDb->mockUpdate('song', $model);
        SongModel::init(['db'=>$this->mockDb]);
        $created = SongModel::create($model);
        $this->assertSame($inserted, $created);
    }

}
