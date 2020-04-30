<?php

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;

if (!function_exists('limit')) {
    /**
     * Get limit to the database query.
     *
     * @param int $limit
     * @return mixed
     */
    function max_query_limit($limit)
    {
        $max_limit = config('core.max_query_limit');

        $limit = (int)$limit ?: config('repository.pagination.limit');
        $limit = ($limit <= $max_limit) ? $limit : $max_limit;

        return $limit;
    }
}

if (!function_exists('order_by')) {
    /**
     * Add an "order by" clause to the query.
     *
     * @param mixed $model
     * @param array $options
     * @return mixed
     */
    function order_by($model, $options = [])
    {
        $orderBy = data_get($options, 'orderBy', 'id');
        $sortedBy = data_get($options, 'sortedBy', 'asc');
        $sortedBy = in_array(strtolower($sortedBy), ['asc', 'desc']) ? $sortedBy : 'asc';

        if (isset($orderBy) && !empty($orderBy)) {
            $split = explode('|', $orderBy);
            if (count($split) > 1) {
                /*
                 * ex.
                 * products|description -> join products on current_table.product_id = products.id order by description
                 *
                 * products:custom_id|products.description -> join products on current_table.custom_id = products.id order
                 * by products.description (in case both tables have same column name)
                 */
                $table = $model->getModel()->getTable();
                $sortTable = $split[0];
                $sortColumn = $split[1];

                $split = explode(':', $sortTable);
                if (count($split) > 1) {
                    $sortTable = $split[0];
                    $keyName = $table . '.' . $split[1];
                } else {
                    /*
                     * If you do not define which column to use as a joining column on current table, it will
                     * use a singular of a join table appended with _id
                     *
                     * ex.
                     * products -> product_id
                     */
                    $prefix = str_singular($sortTable);
                    $keyName = $table . '.' . $prefix . '_id';
                }

                $model = $model
                    ->leftJoin($sortTable, $keyName, '=', $sortTable . '.id')
                    ->orderBy($sortColumn, $sortedBy)
                    ->addSelect($table . '.*');
            } else {
                $model = $model->orderBy($orderBy, $sortedBy);
            }
        }

        return $model;
    }
}

if (!function_exists('with')) {
    /**
     * Set the relationships that should be eager loaded.
     *
     * @param $model
     * @param $with
     * @return mixed
     */
    function with($model, $with = null)
    {
        if ($with) {
            $with = explode(';', $with);
            $model = $model->with($with);
        }

        return $model;
    }
}

if (!function_exists('search')) {
    /**
     * Add an "search" clause to the query.
     *
     * @param $model
     * @param array $options
     * @param RepositoryInterface|string $repository
     * @return mixed
     * @throws Exception
     */
    function search($model, $options = [], $repository)
    {
        if (is_string($repository)) {
            $repository = app($repository);
        }

        $fieldsSearchable = $repository->getFieldsSearchable();
        $search = data_get($options, 'search');
        $searchFields = data_get($options, 'searchFields');
        $searchJoin = data_get($options, 'searchJoin');

        if ($search && is_array($fieldsSearchable) && count($fieldsSearchable)) {
            $searchFields = is_array($searchFields) || is_null($searchFields) ? $searchFields : explode(';', $searchFields);
            $fields = parser_fields_search($fieldsSearchable, $searchFields);
            $isFirstField = true;
            $searchData = parser_search_data($search);
            $search = parser_search_value($search);
            $modelForceAndWhere = strtolower($searchJoin) === 'and';

            $model = $model->where(function ($query) use ($fields, $search, $searchData, $isFirstField, $modelForceAndWhere) {
                /** @var Builder $query */

                foreach ($fields as $field => $condition) {
                    if (is_numeric($field)) {
                        $field = $condition;
                        $condition = "=";
                    }

                    $value = null;

                    $condition = trim(strtolower($condition));

                    if (isset($searchData[$field])) {
                        $value = ($condition == "like" || $condition == "ilike") ? "%{$searchData[$field]}%" : $searchData[$field];
                    } else {
                        if (!is_null($search)) {
                            $value = ($condition == "like" || $condition == "ilike") ? "%{$search}%" : $search;
                        }
                    }

                    $relation = null;
                    if (stripos($field, '.')) {
                        $explode = explode('.', $field);
                        $field = array_pop($explode);
                        $relation = implode('.', $explode);
                    }
                    $modelTableName = $query->getModel()->getTable();
                    if ($isFirstField || $modelForceAndWhere) {
                        if (!is_null($value)) {
                            if (!is_null($relation)) {
                                $query->whereHas($relation, function ($query) use ($field, $condition, $value) {
                                    $query->where($field, $condition, $value);
                                });
                            } else {
                                $query->where($modelTableName . '.' . $field, $condition, $value);
                            }
                            $isFirstField = false;
                        }
                    } else {
                        if (!is_null($value)) {
                            if (!is_null($relation)) {
                                $query->orWhereHas($relation, function ($query) use ($field, $condition, $value) {
                                    $query->where($field, $condition, $value);
                                });
                            } else {
                                $query->orWhere($modelTableName . '.' . $field, $condition, $value);
                            }
                        }
                    }
                }
            });
        }

        return $model;
    }
}

if (!function_exists('parser_search_value')) {
    /**
     * Parser search value.
     *
     * @param $search
     * @return string|null
     */
    function parser_search_value($search)
    {
        if (stripos($search, ';') || stripos($search, ':')) {
            $values = explode(';', $search);
            foreach ($values as $value) {
                $s = explode(':', $value);
                if (count($s) == 1) {
                    return $s[0];
                }
            }

            return null;
        }

        return $search;
    }
}

if (!function_exists('parser_fields_search')) {
    /**
     * Parser fields of search.
     *
     * @param array $fields
     * @param array|null $searchFields
     * @return array
     * @throws Exception
     */
    function parser_fields_search(array $fields = [], array $searchFields = null)
    {
        if (!is_null($searchFields) && count($searchFields)) {
            $acceptedConditions = config('repository.criteria.acceptedConditions', [
                '=',
                'like'
            ]);
            $originalFields = $fields;
            $fields = [];

            foreach ($searchFields as $index => $field) {
                $field_parts = explode(':', $field);
                $temporaryIndex = array_search($field_parts[0], $originalFields);

                if (count($field_parts) == 2) {
                    if (in_array($field_parts[1], $acceptedConditions)) {
                        unset($originalFields[$temporaryIndex]);
                        $field = $field_parts[0];
                        $condition = $field_parts[1];
                        $originalFields[$field] = $condition;
                        $searchFields[$index] = $field;
                    }
                }
            }

            foreach ($originalFields as $field => $condition) {
                if (is_numeric($field)) {
                    $field = $condition;
                    $condition = "=";
                }
                if (in_array($field, $searchFields)) {
                    $fields[$field] = $condition;
                }
            }

            if (count($fields) == 0) {
                throw new Exception(trans('repository::criteria.fields_not_accepted', ['field' => implode(',', $searchFields)]));
            }
        }

        return $fields;
    }
}

if (!function_exists('parser_search_data')) {
    /**
     * Parser search data.
     *
     * @param $search
     * @return array
     */
    function parser_search_data($search)
    {
        $searchData = [];

        if (stripos($search, ':')) {
            $fields = explode(';', $search);

            foreach ($fields as $row) {
                try {
                    list($field, $value) = explode(':', $row);
                    $searchData[$field] = $value;
                } catch (Exception $e) {
                    //Surround offset error
                }
            }
        }

        return $searchData;
    }
}
