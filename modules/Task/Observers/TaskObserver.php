<?php

namespace Modules\Task\Observers;

use Illuminate\Support\Str;
use Modules\Task\Entities\Task;

class TaskObserver
{
    /**
     * Handle the Task "creating" event.
     *
     * @param Task $task
     * @return void
     */
    public function creating(Task $task)
    {
        $task->setAttribute('uuid', Str::uuid());
    }
}
