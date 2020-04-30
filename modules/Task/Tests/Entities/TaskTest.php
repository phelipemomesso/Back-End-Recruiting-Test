<?php

namespace Modules\Task\Tests\Entities;

use Modules\Task\Entities\Task;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * The entity instance.
     *
     * @var Type
     */
    protected $model;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->model = $this->app->make(Task::class);
    }

    /**
     * Test it can specify table name.
     *
     * @return void
     */
    public function testItCanSpecifyTableName(): void
    {
        $this->assertEquals($this->model->getTable(), 'task_tasks');
    }

    /**
     * Test it can specify fillable fields.
     *
     * @return void
     */
    public function testItCanSpecifyFillableFields(): void
    {
        $fillable = [
            'type', 'content', 'sort_order', 'done'
        ];

        $this->assertTrue($fillable == $this->model->getFillable());
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }
}
