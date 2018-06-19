<?php

namespace FederalSt\Http\Requests\Vehicles;

use FederalSt\Vehicle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $vehicle = Vehicle::find($this->get('id'));
        if (Auth::user()->can('vehicles.store', $vehicle)) {
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
            'vehicle_model' => 'required|string|date_format:"Y"',
            'renavam' => 'required|string|max:11'

        ];
    }

    /**
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $errors)
    {
        return Response::json($errors, 403);
    }
}
