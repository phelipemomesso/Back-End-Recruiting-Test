<?php

namespace Modules\Task\Services;

use Modules\Core\Services\BaseService;
use Modules\Task\Repositories\TaskRepository;

class TaskService extends BaseService
{
    /**
     * The repository instance.
     *
     * @var TaskRepository
     */
    protected $repository = TaskRepository::class;
}
