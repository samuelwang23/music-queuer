<?php

namespace Neoan3\Model\Review;

use Neoan3\Provider\MySql\Database;
use Neoan3\Provider\MySql\MockDatabaseWrapper;
use PHPUnit\Framework\TestCase;

/**
 * Class PostTest
 * @package Neoan3\Model
 */
class ReviewTest extends TestCase
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
        $model = $this->mockDb->mockGet('review');
        ReviewModel::init(['db'=>$this->mockDb]);
        $res = ReviewModel::get($model['id']);
        $this->assertIsArray($res);
        $this->assertSame($model, $res);
    }

    /**
     * Test update
     */
    public function testUpdate()
    {
        $model = $this->mockDb->mockModel('review');
        $model[array_keys($model)[0]] = 'abc';
        $this->mockDb->mockUpdate('review', $model);
        ReviewModel::init(['db'=>$this->mockDb]);
        $result = ReviewModel::update($model);
        $this->assertSame($result[array_keys($model)[0]], 'abc');
    }

    /**
     * Test creation
     */
    public function testCreate()
    {
        $model = $this->mockDb->mockModel('review');
        $this->mockDb->registerResult([['id' => '123456789']]);
        $inserted = $this->mockDb->mockUpdate('review', $model);
        ReviewModel::init(['db'=>$this->mockDb]);
        $created = ReviewModel::create($model);
        $this->assertSame($inserted, $created);
    }

}
