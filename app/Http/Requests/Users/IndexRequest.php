<?php

namespace FederalSt\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'per_page' => 'nullable|numeric',
            'all' => 'nullable|boolean',
            'filter' => 'nullable|string',
            'vehicle_id' => 'nullable|integer|exists:vehicles,id'
        ];
    }
}
