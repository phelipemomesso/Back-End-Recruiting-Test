<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
                    'name' => [
                        'required', 'max:255',
                    ],
                    'email' => [
                        'required', 'email', 'max:255', 'unique:user_users,email',
                    ],
                    'password' => [
                        'required', 'min:8', 'max:32',
                    ],
                ];
            case Request::METHOD_PUT:
                return [
                    'name' => [
                        'required', 'max:255',
                    ],
                    'email' => [
                        'required', 'email', 'max:255', Rule::unique('user_users')->ignore($this->route('user'), 'id'),
                    ],
                    'password' => [
                        'min:8', 'max:32',
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
