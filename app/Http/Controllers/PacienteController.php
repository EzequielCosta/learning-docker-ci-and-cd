<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class PacienteController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
//        $validated = $request->validate([
//            "nome" => "required",
//            "data_nascimento" => "required",
//            "cpf" => "required|max:11",
//            "telefone" => "required|max:11",
//            "sexo" => "required|max:1",
//            "endereco" => "required|max:200",
//        ]);

        $data = $request->all();

        try {
            $validator = Validator::make(
                $data,
                [
                    "nome" => "required",
                    "nome_mae" => "required",
                    "data_nascimento" => "required",
                    "cpf" => "required|digits:11",
                    "telefone" => "required|digits:11",
                    "sexo" => "required|max:1",
                    "endereco" => "required|max:200",
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    'message' => $validator->errors()->all()
                ],
                    422);
            }

            Paciente::create([
                "nome" => $data["nome"],
                "nome_mae" => $data["nome_mae"],
                "data_nascimento" => $data["data_nascimento"],
                "cpf" => $data["cpf"],
                "telefone" => $data["telefone"],
                "sexo" => $data["sexo"],
                "endereco" => $data["endereco"],
            ]);

            return response()->json([
                "status" => true,
                "message" => "Paciente criado com sucesso"
            ], 201);
        } catch (\Exception  $exception){
            return response()->json([
                "status" => false,
                "message" => "Não foi possível completar a requisição"
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @param int $pacienteId
     * @return JsonResponse
     */
    public function update(Request $request, int $pacienteId): JsonResponse
    {
        try {
            $data = $request->all();
            $validator = Validator::make(
                $data,
                [
                    "cpf" => "digits:11",
                    "telefone" => "digits:11",
                    "sexo" => "min:1|max:1",
                    "endereco" => "max:200",
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    'message' => $validator->errors()->all()
                ],
                    404);
            }

            $dataToSave = Arr::whereNotNull([
                "nome" => $data["nome"] ?? null,
                "nome_mae" => $data["nome_mae"] ?? null,
                "data_nascimento" => $data["data_nascimento"] ?? null,
                "cpf" => $data["cpf"] ?? null,
                "telefone" => $data["telefone"] ?? null,
                "sexo" => $data["sexo"] ?? null,
                "endereco" => $data["endereco"] ?? null,
            ]);

            $pacienteEncontrado = Paciente::query()->find($pacienteId);

            if ($pacienteEncontrado === null) {
                return response()->json([
                    "status" => false,
                    "message" => "Não foi possível encontrar o registro"
                ], 404);
            }

            $pacienteEncontrado->update($dataToSave);

            return response()->json([
                "status" => true,
                "message" => "Paciente atualizado com sucesso"
            ]);

        } catch (\Exception $exception){
            return response()->json([
                "status" => false,
                "message" => "Não foi possível completar a requisição"
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @param $pacienteId
     * @return JsonResponse
     */
    public function show(Request $request, $pacienteId): JsonResponse
    {
        try {
            $pacienteEncontrado = Paciente::query()->find($pacienteId);

            if ($pacienteEncontrado === null) {
                return response()->json([
                    "status" => false,
                    "message" => "Não foi possível encontrar o registro"
                ], 404);
            }

            return response()->json([
                "status" => true,
                "message" => "Paciente retornado com sucesso",
                "data" => [
                    "paciente" => $pacienteEncontrado->toArray()
                ]
            ]);
        }catch (\Exception $exception) {
            return response()->json([
                "status" => false,
                "message" => "Não foi possível completar a requisição"
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function showAll(Request $request): JsonResponse
    {
        try {
            $pacientes = Paciente::all();

            return response()->json([
                "status" => true,
                "message" => "Pacientes retornados com sucesso",
                "data" => [
                    "pacientes" => $pacientes
                ]
            ]);
        }catch (\Exception $exception) {
            return response()->json([
                "status" => false,
                "message" => "Não foi possível completar a requisição"
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @param int $pacienteId
     * @return JsonResponse
     */
    public function delete(Request $request, int $pacienteId): JsonResponse
    {
        try {
            $pacienteEncontrado = Paciente::query()->find($pacienteId)?->delete();

            return response()->json([
                "status" => true,
                "message" => "Paciente deletado com sucesso"
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "status" => false,
                "message" => "Não foi possível completar a requisição"
            ], 500);
        }
    }
}
