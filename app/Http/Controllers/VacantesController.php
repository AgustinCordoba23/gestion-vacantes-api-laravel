<?php

namespace App\Http\Controllers;

use App\Http\Requests\VacanteRequest;
use App\Http\Resources\VacanteResource;
use App\Models\Vacante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VacantesController
{

    public function crear(VacanteRequest $request) {
        $campos = $request->only('catedra', 'descripcion', 'fecha_fin');

        $vacante = Vacante::create([
            'catedra' => $campos['catedra'],
            'descripcion' => $campos['descripcion'],
            'fecha_fin' => $campos['fecha_fin'],
        ]);

        return new VacanteResource($vacante);
    }

    public function listar(Request $request) {
        $filtros = $request->input('filtros', []);
        $vacantes = DB::table("vacantes");

        foreach ($filtros as $key => $value) {
            $vacantes->where($key, 'LIKE', '%'.$value.'%');
        }

        $vacantes = $vacantes->get();

        return $vacantes;
    }
}
