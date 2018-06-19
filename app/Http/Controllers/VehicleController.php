<?php

namespace FederalSt\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class VehicleController extends Controller
{
    public function index()
    {
        try {
            return 0;
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
