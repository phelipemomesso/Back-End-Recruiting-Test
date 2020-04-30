<?php

namespace Modules\Task\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Task\Http\Requests\TaskRequest;
use Modules\Task\Http\Resources\TaskResource;
use Modules\Task\Services\TaskService;

class TaskController extends Controller
{
    /**
     * The service instance.
     *
     * @var TaskService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param TaskService $service
     * @return void
     */
    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return TaskResource::collection($this->service->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskRequest $request
     * @return Response
     */
    public function store(TaskRequest $request)
    {
        $entity = $this->service->create($request->all());
        $data = TaskResource::make($entity);
        return response()->json(['data' => $data], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return TaskResource
     */
    public function show($id)
    {
        return TaskResource::make($this->service->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskRequest $request
     * @param int $id
     * @return TaskResource
     */
    public function update(TaskRequest $request, $id)
    {
        $entity = $this->service->update($request->all(), $id);
        return TaskResource::make($entity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = $this->service->delete($id);
        return response()->json(['data' => $data], Response::HTTP_NO_CONTENT);
    }
}
