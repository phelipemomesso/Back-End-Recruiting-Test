<?php

namespace Modules\Task\Tests\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Modules\Task\Entities\Task;
use Modules\Task\Services\TaskService;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    /**
     * The service instance.
     *
     * @var TaskService
     */
    protected $service;

    /**
     * The entity instance.
     *
     * @var Task
     */
    protected $type;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');
        Artisan::call('passport:install');

        $this->service = $this->app->make(TaskService::class);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity(): void
    {
        $values = factory(Task::class)->make()->toArray();

        $entity = $this->service->create($values);
        $data = $entity->toArray();

        $this->assertDatabaseHas('task_tasks', $values);
        $this->assertInstanceOf(Task::class, $entity);

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Structure of response entity.
     *
     * @return array
     */
    private function dataStructure()
    {
        return [
            'type', 'content', 'sort_order', 'done', 'created_at', 'updated_at',
        ];
    }

    /**
     * Test it can display a listing of the entity.
     *
     * @return void
     */
    public function testItCanListingEntity(): void
    {
        $amount = 2;
        factory(Task::class, $amount)->create();

        $list = $this->service->paginate();
        $data = current($list->items())->toArray();

        $this->assertInstanceOf(LengthAwarePaginator::class, $list);
        $this->assertEquals($amount, $list->total());

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can show the specified entity.
     *
     * @return void
     */
    public function testItCanShowEntity(): void
    {
        $fake = factory(Task::class)->create();
        $entity = $this->service->find($fake->uuid);
        $data = $entity->toArray();

        $this->assertInstanceOf(Task::class, $entity);

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can update the specified entity in storage.
     *
     * @return void
     */
    public function testItCanUpdateEntity(): void
    {
        $entity = factory(Task::class)->create();
        $values = factory(Task::class)->make()->toArray();
        $entity->update($values);

        $this->assertDatabaseHas('task_tasks', $values);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity(): void
    {
        $entity = factory(Task::class)->create();

        $response = $this->service->delete($entity->uuid);

        $this->assertTrue($response);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown(): void
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
}
