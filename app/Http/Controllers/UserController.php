<?php

namespace FederalSt\Http\Controllers;

use FederalSt\Http\Requests\Users\IndexRequest;
use FederalSt\Http\Requests\Users\LoginRequest;
use FederalSt\Http\Resources\User as UserResource;
use FederalSt\Http\Resources\UserCollection;
use FederalSt\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    /**
     * UserController - index
     * Método feito para buscar um conjunto de usuários através de uma pesquisa que pode ser tanto simples quanto avançada.
     * Além disso, ela pode ser paginada ou não.
     * @param IndexRequest $request
     * @return UserCollection|\Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
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

    /**
     * UserController - login
     * Esse método tem como objetivo realizar o Login dos Usuários na plataforma.
     * @param LoginRequest $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $email = $request->input('email');
            $password = $request->input('password');
            $user = User::where('email', $email)->first();

            $userData = [
                'email' => $email,
                'password' => $password
            ];

            if (Auth::attempt($userData)) {
                if (!$user->api_token) {
                    $user->api_token = Hash::make($user->id.$user->name.$user->cpf);
                    $user->save();
                }
                return new UserResource($user);
            } else {
                return Response::json(['Email ou Senha são inválidos!'], 400);
            }
        } catch (\Exception $exception) {
            return Response::json(['Ocorreu um erro Inesperado! Segue Erro: '.$exception->getMessage()], 500);
        }
    }

    /**
     * UserController - logout
     * Esse Método tem como objetivo realizar o logout do sistema pelo usuário já logado.
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            $user = Auth::user();
            if ($user) {
                Auth::logout();
                return Response::json(['Logout feito com sucesso.']);
            } else {
                return Response::json(['Usuário não está logado.'], 401);
            }
        } catch (\Exception $exception) {
            return Response::json(['Ocorreu um erro Inesperado! Segue Erro: '.$exception->getMessage()], 500);
        }
    }
}
