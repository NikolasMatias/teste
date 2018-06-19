<?php

namespace FederalSt\Http\Requests\Vehicles;

use FederalSt\Vehicle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $vehicle = Vehicle::find($this->get('id'));
        if (Auth::user()->can('vehicles.update', $vehicle)) {
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
            'owner_id' => 'required|integer|exists:users,id',
            'plate' => 'required|string|max:8',
            'brand' => 'required||string',
            'year' => 'required|string|date_format:"Y"',
            'model' => 'required|string|date_format:"Y"',
            'renavam' => 'required|string|max:11'
        ];
    }
}
