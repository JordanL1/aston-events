<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;

class CreateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('createEvent');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:events|max:255',
            'description' => 'nullable|max:2500',
            'location' => 'required|max:255',
            'category' => 'required',
            'date_time' => 'required',
            'photos' => 'array',
            'photos.*' => 'image|mimes:jpeg,bmp,png|max:2000'
        ];
    }
}
