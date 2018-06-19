<?php

namespace FederalSt\Http\Controllers;

use FederalSt\Http\Requests\Vehicles\IndexRequest;
use FederalSt\Http\Resources\Vehicle as VehicleResource;
use FederalSt\Http\Resources\VehicleCollection;
use FederalSt\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class VehicleController extends Controller
{
    /**
     * VehicleController - index
     * Esse Método busca diversos Veículos, paginados ou não, de acordo com a pesquisa passada a baixo.
     * @param IndexRequest $request
     * @return VehicleCollection|\Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexRequest $request)
    {
        try {
            $all = $request->input('all');
            $per_page = $request->input('per_page');
            $filter = $request->input('filter');
            $owner_id = $request->input('owner_id');

            $vehicles = Vehicle::with('owner');

            if ($owner_id) {
                $vehicles = $vehicles->where('owner_id', $owner_id);
            }

            if ($filter) {
                $vehicles = $vehicles->search($filter, [
                    'plate' => 10,
                    'renavam' => 10,
                    'brand' => 9,
                    'model' => 8,
                    'year' => 8,
                ]);
            }

            if ($all) {
                $vehicles = $vehicles->get();

                return VehicleResource::collection($vehicles);
            } else {
                if ($per_page) {
                    $vehicles = $vehicles->paginate($per_page);
                } else {
                    $vehicles = $vehicles->paginate(20);
                }

                return new VehicleCollection($vehicles);
            }
        } catch (\Exception $exception) {
            return Response::json(['Ocorreu um erro Inesperado! Segue Erro: '.$exception->getMessage()], 500);
        }
    }

    public function store()
    {
        try {
            return 0;
        } catch (\Exception $exception) {
            return Response::json(['Ocorreu um erro Inesperado! Segue Erro: '.$exception->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            return 0;
        } catch (\Exception $exception) {
            return Response::json(['Ocorreu um erro Inesperado! Segue Erro: '.$exception->getMessage()], 500);
        }
    }

    public function update()
    {
        try {
            return 0;
        } catch (\Exception $exception) {
            return Response::json(['Ocorreu um erro Inesperado! Segue Erro: '.$exception->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            return 0;
        } catch (\Exception $exception) {
            return Response::json(['Ocorreu um erro Inesperado! Segue Erro: '.$exception->getMessage()], 500);
        }
    }
}
