<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update', $this->project());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'sometimes|required | min:3 | max:255',
            'description' => 'sometimes|required | min:3 | max:100',
            'notes' => 'nullable',
        ];
    }

    public function save(){
        $this->project()->update($this->validated());
    }

    public function project(){
        return $this->route('project');
    }
}
