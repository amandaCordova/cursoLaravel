<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActorRequest extends FormRequest
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
        return [
            'nombres'=>'required|string|max:30',
            'apellidos'=>'required|string|max:30',
            'imagen'=>'nullable|file|mimes:jpeg,png,jpg,JPG|dimensions:min_width=400,min_height=400,max_width=2000,max_height=2000|max:2048',
        ];
    }
}
