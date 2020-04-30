<?php

namespace Modules\Task\Tests\Repositories;

use Modules\Task\Entities\Task;
use Modules\Task\Repositories\TaskRepository;
use Tests\TestCase;

class TaskRepositoryTest extends TestCase
{
    /**
     * The repository instance.
     *
     * @var TaskRepository
     */
    protected $repository;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->app->make(TaskRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName(): void
    {
        $this->assertEquals($this->repository->model(), Task::class);
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
