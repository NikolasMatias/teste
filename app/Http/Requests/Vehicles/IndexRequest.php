<?php

namespace FederalSt\Http\Requests\Vehicles;

use FederalSt\Vehicle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class IndexRequest extends FormRequest
{
    protected $forceJsonResponse = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $vehicle = new Vehicle();
        if (Auth::user()->can('vehicles.index', $vehicle)) {
            return true;
        }
        return false;
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
            'owner_id' => 'nullable|integer|exists:users,id'
        ];
    }


    /**
     * [failedValidation [Overriding the event validator for custom error response]]
     * @param  Validator $validator [description]
     * @return [object][object of various validation errors]
     */
    public function failedValidation(Validator $validator) {
        //write your bussiness logic here otherwise it will give same old JSON response
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
