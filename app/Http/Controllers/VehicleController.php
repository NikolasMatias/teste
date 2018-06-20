<?php

namespace FederalSt\Http\Controllers;

use FederalSt\Events\VehicleDestroy;
use FederalSt\Events\VehicleStore;
use FederalSt\Events\VehicleUpdate;
use FederalSt\Http\Requests\Vehicles\IndexRequest;
use FederalSt\Http\Requests\Vehicles\StoreRequest;
use FederalSt\Http\Requests\Vehicles\UpdateRequest;
use FederalSt\Http\Resources\Vehicle as VehicleResource;
use FederalSt\Http\Resources\VehicleCollection;
use FederalSt\User;
use FederalSt\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                    'plate' => 15,
                    'renavam' => 10,
                    'brand' => 9,
                    'vehicle_model' => 8,
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

    /**
     * VehicleController - store
     * Esse Método foi feito para a criação de veículos.
     * @param StoreRequest $request
     * @return VehicleResource|\Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        try {
            $owner_id = $request->input('owner_id');

            $vehicle = Vehicle::create([
                'owner_id' => $owner_id,
                'plate' => $request->input('plate'),
                'brand' => $request->input('brand'),
                'year' => $request->input('year'),
                'vehicle_model' => $request->input('vehicle_model'),
                'renavam' => $request->input('renavam')
            ]);

            if ($vehicle) {
                $user = User::find($owner_id);
                event(new VehicleStore($user, $vehicle));

                return new VehicleResource($vehicle);
            } else {
                return Response::json(['Problema ao criar o Veículo.'], 500);
            }
        } catch (\Exception $exception) {
            return Response::json(['Ocorreu um erro Inesperado! Segue Erro: '.$exception->getMessage()], 500);
        }
    }

    /**
     * VehicleController - show
     * Esse Método tem como objetivo buscar apenas um Veículo.
     * @param $id
     * @return VehicleResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $vehicle = Vehicle::with('owner')
                ->where('id', $id)->first();
            if ($vehicle) {
                return new VehicleResource($vehicle);
            } else {
                return Response::json(['Dados não encontrados'], 500);
            }
        } catch (\Exception $exception) {
            return Response::json(['Ocorreu um erro Inesperado! Segue Erro: '.$exception->getMessage()], 500);
        }
    }

    /**
     * VehicleController - update
     * Esse Método tem como objetivo atualizar  os dados de um Veículo.
     * @param UpdateRequest $request
     * @param $id
     * @return VehicleResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $owner_id = $request->input('owner_id');
            $plate = $request->input('plate');
            $brand = $request->input('brand');
            $year = $request->input('year');
            $vehicle_model = $request->input('vehicle_model');
            $renavam = $request->input('renavam');

            $vehicle = Vehicle::with('owner')
                ->where('id', $id)->first();

            if ($vehicle) {
                $vehicle->owner_id = $owner_id;
                $vehicle->plate = $plate;
                $vehicle->brand = $brand;
                $vehicle->year = $year;
                $vehicle->vehicle_model = $vehicle_model;
                $vehicle->renavam = $renavam;

                if ($vehicle->save()) {
                    $user = User::find($owner_id);
                    event(new VehicleUpdate($user, $vehicle));

                    return new VehicleResource($vehicle);
                } else {
                    return Response::json(['Problema ao salvar os Dados no Banco.'], 500);
                }
            } else {
                return Response::json(['Dados não encontrados'], 500);
            }
        } catch (\Exception $exception) {
            return Response::json(['Ocorreu um erro Inesperado! Segue Erro: '.$exception->getMessage()], 500);
        }
    }

    /**
     * VehicleController - destroy
     * Esse Método tem como objetivo destruir um Veículo.
     * @param $id
     * @return VehicleResource|\Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $vehicle = Vehicle::with('owner')
                ->where('id', $id)->first();
            if ($vehicle) {
                if ($vehicle->delete()) {
                    $user = User::find($vehicle->owner_id);
                    event(new VehicleDestroy($user, $vehicle));

                    return new VehicleResource($vehicle);
                } else {
                    return Response::json(['Problema ao excluir um Veículo.'], 500);
                }
            } else {
                return Response::json(['Dados não encontrados'], 500);
            }
        } catch (\Exception $exception) {
            return Response::json(['Ocorreu um erro Inesperado! Segue Erro: '.$exception->getMessage()], 500);
        }
    }
}
