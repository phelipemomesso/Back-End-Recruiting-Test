<?php

namespace Modules\Core\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class BaseRequestCriteria implements CriteriaInterface
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Builder $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $hasQuery = $this->request->get('has', null);
        $withCount = $this->request->get('withCount', null);
        $findWhereIn = $this->request->get('findWhereIn', null);


        if (!empty($hasQuery)) {
            foreach (explode('|', $hasQuery) as $has) {
                $arguments = explode(',', $has);
                $relation = $arguments[0];
                $wheres = $this->parseArguments(array_get($arguments, 1, []));
                $operators = $this->parseArguments(array_get($arguments, 2));

                $model->whereHas($relation, function (Builder $query) use ($arguments, $relation, $wheres, $operators) {
                    foreach ($wheres as $field => $value) {
                        $query->where($field, array_get($operators, $field, '='), $value);
                    }
                });
            }
        }

        if (!empty($findWhereIn)) {
            $params = $this->parseArguments($findWhereIn);
            $model = $model->whereIn($params['field'], explode(',', $params['values']));
        }

        if (!empty($withCount)) {
            $withCount = explode(';', $withCount);
            $model = $model->withCount($withCount);
        }

        return $model;
    }

    /**
     * Parse arguments of a method.
     *
     * @param string $argument
     * @return array
     */
    private function parseArguments($argument)
    {
        $data = [];
        if ($argument) {
            foreach (explode(';', $argument) as $item) {
                list($key, $value) = explode(':', $item);
                $data[$key] = $value;
            }
        }
        return $data;
    }
}
