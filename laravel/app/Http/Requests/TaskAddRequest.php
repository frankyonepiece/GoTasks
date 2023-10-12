<?php

namespace App\Http\Requests;

use App\Rules\UniqueTitle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = request()->user();
        $rules = [
            'title' => [ 'required', Rule::unique('tasks', 'title')->where(function($query) use ($user) {
                return $query->where('user_id', $user->id);
            }) ],
            'description' => 'nullable',
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['title'] = [ 'required' ];
        }

        return $rules;
    }
}
