<?php

namespace Modules\Task\Repositories;

use Modules\Task\Entities\Task;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class TaskRepositoryEloquent extends BaseRepository implements TaskRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type' => '=',
        'content' => 'ilike',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Task::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
