<?php

namespace Modules\Task\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            case Request::METHOD_POST:
                return [
                    'type' => [
                        'required', 'in:shopping,work',
                    ],
                    'content' => [
                        'required',
                    ],
                    'sort_order' => [
                        'required', 'integer',
                    ],
                    'done' => [
                        'boolean',
                    ],
                ];
            case Request::METHOD_PUT:
                return [
                    'type' => [
                        'required', 'in:shopping,work',
                    ],
                    'content' => [
                        'required',
                    ],
                    'sort_order' => [
                        'required', 'integer',
                    ],
                    'done' => [
                        'boolean',
                    ],
                ];
            default:
                return [];
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
