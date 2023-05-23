<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createCardRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'title.ar' => 'required',
            'title.en' => 'required',
            'description.ar' => 'required',
            'description.en' => 'required',
            'attachment' => ['required', 'image'],
        ];
    }

    public function messages()
    {
        return [
            'attachment.required' => 'the image field is required',
        ];
    }
}
