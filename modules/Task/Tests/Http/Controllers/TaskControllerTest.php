<?php

namespace Modules\Task\Tests\Http\Controllers\Tests;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Modules\Task\Entities\Task;
use Modules\User\Entities\User;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
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

    }

    /**
     * Test it can store a newly created resource in storage.
     *
     * @return void
     */
    public function testItCanCreateResource(): void
    {
        if (!Route::has('task.tasks.store')) {
            $this->markTestIncomplete('Method Not Allowed');
        }

        $values = factory(Task::class)->make()->toArray();

        $response = $this->post(route('task.tasks.store'), $values);

        $data = $response->json();

        foreach ($values as $key => $value) {
            $this->assertEquals($data['data'][$key], $value);
        }

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure($this->jsonStructure());
    }

    /**
     * Structure of response resource.
     *
     * @return array
     */
    private function jsonStructure()
    {
        return [
            'data' => [
               'uuid' ,'type', 'content', 'sort_order', 'done', 'created_at', 'updated_at',
            ],
        ];
    }

    /**
     * Test it can show the specified resource.
     *
     * @return void
     */
    public function testItCanShowResource(): void
    {
        if (!Route::has('task.tasks.show')) {
            $this->markTestIncomplete('Method Not Allowed');
        }

        $entity = factory(Task::class)->create();

        $response = $this->get(route('task.tasks.show', ['category' => $entity->uuid]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure($this->jsonStructure());
    }

    /**
     * Test it can update the specified resource in storage.
     *
     * @return void
     */
    public function testItCanUpdateResource(): void
    {
        if (!Route::has('task.tasks.update')) {
            $this->markTestIncomplete('Method Not Allowed');
        }

        $entity = factory(Task::class)->create();

        $values = factory(Task::class)->make()->toArray();

        $response = $this->put(route('task.tasks.update', ['category' => $entity->uuid]), $values);

        $data = $response->json();

        foreach ($values as $key => $value) {
            $this->assertEquals($data['data'][$key], $value);
        }

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure($this->jsonStructure());
    }

    /**
     * Test it can remove the specified resource from storage.
     *
     * @return void
     */
    public function testItCanDestroyResource(): void
    {
        if (!Route::has('task.tasks.destroy')) {
            $this->markTestIncomplete('Method Not Allowed');
        }

        $entity = factory(Task::class)->create();

        $response = $this->delete(route('task.tasks.destroy', ['category' => $entity->uuid]));
        $response->assertStatus(Response::HTTP_NO_CONTENT);
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
