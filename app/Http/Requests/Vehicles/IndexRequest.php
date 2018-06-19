<?php

namespace FederalSt\Http\Requests\Vehicles;

use FederalSt\Vehicle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $vehicle = Vehicle::find($this->get('id'));
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
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $errors)
    {
        return Response::json($errors, 403);
    }
}
