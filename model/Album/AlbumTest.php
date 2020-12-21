<?php

namespace Neoan3\Model\Album;

use Neoan3\Provider\MySql\Database;
use Neoan3\Provider\MySql\MockDatabaseWrapper;
use PHPUnit\Framework\TestCase;

/**
 * Class PostTest
 * @package Neoan3\Model
 */
class AlbumTest extends TestCase
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
        $model = $this->mockDb->mockGet('album');
        AlbumModel::init(['db'=>$this->mockDb]);
        $res = AlbumModel::get($model['id']);
        $this->assertIsArray($res);
        $this->assertSame($model, $res);
    }

    /**
     * Test update
     */
    public function testUpdate()
    {
        $model = $this->mockDb->mockModel('album');
        $model[array_keys($model)[0]] = 'abc';
        $this->mockDb->mockUpdate('album', $model);
        AlbumModel::init(['db'=>$this->mockDb]);
        $result = AlbumModel::update($model);
        $this->assertSame($result[array_keys($model)[0]], 'abc');
    }

    /**
     * Test creation
     */
    public function testCreate()
    {
        $model = $this->mockDb->mockModel('album');
        $this->mockDb->registerResult([['id' => '123456789']]);
        $inserted = $this->mockDb->mockUpdate('album', $model);
        AlbumModel::init(['db'=>$this->mockDb]);
        $created = AlbumModel::create($model);
        $this->assertSame($inserted, $created);
    }

}
