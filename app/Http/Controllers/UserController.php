<?php

namespace FederalSt\Http\Controllers;

use FederalSt\Http\Requests\Users\IndexRequest;
use FederalSt\Http\Resources\User as UserResource;
use FederalSt\Http\Resources\UserCollection;
use FederalSt\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function index(IndexRequest $request)
    {
        try {
            $all = $request->input('all');
            $per_page = $request->input('per_page');
            $filter = $request->input('filter');
            $vehicle_id = $request->input('vehicle_id');

            $users = User::with('vehicles');

            if ($filter) {
                $users = $users->search($filter, [
                    'name' => 10,
                    'cpf' => 9,
                    'email' => 8,
                    'phone' => 7,
                    'vehicles.plate' => 5,
                    'vehicles.brand' => 5,
                    'vehicles.model' => 5,
                    'vehicles.year' => 5,
                    'vehicles.renavam' => 5
                ]);
            }

            if ($vehicle_id) {
                $users = $users->whereHas('vehicles', function ($queryVechicles) use ($vehicle_id) {
                    $queryVechicles->where('id', $vehicle_id);
                });
            }

            if ($all) {
                $users = $users->get();

                return UserResource::collection($users);
            } else {
                if ($per_page) {
                    $users = $users->paginate($per_page);
                } else {
                    $users = $users->paginate(20);
                }

                return new UserCollection($users);
            }
        } catch (\Exception $exception) {
            return Response::json(['Ocorreu um erro Inesperado! Segue Erro: '.$exception->getMessage()], 500);
        }
    }

    public function login()
    {
        try {
            return 0;
        } catch (\Exception $exception) {
            return Response::json(['Ocorreu um erro Inesperado! Segue Erro: '.$exception->getMessage()], 500);
        }
    }
}
