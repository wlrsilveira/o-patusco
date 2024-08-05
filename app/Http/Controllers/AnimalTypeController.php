<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnimalTypeResourceCollection;
use App\Http\Resources\ExceptionResource;
use App\Models\AnimalType;
use Illuminate\Http\JsonResponse;

/**
 * @group Animal Types
 */
class AnimalTypeController extends Controller
{

    /**
     * Get a list of animal types.
     * * @authenticated
     * @header Content-Type application/json
     * @header Accept application/json
     * @header Authorization Bearer {token}
     * @response 200 {
     * "data": [
     *     {
     *         "id": 2,
     *         "description": "Cachorro",
     *     },
     *     {
     *         "id": 3,
     *         "description": "Gato",
     *     },
     * ]
     * @response 403 {
     *   "message": "Unauthorized"
     * }
     *
     * @param  \App\Models\AnimalType  $animalType
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json(
                AnimalTypeResourceCollection::collection(
                    AnimalType::all()
                ),
                200
            );
        } catch (\Exception $e) {
            return (new ExceptionResource([
                'message' => $e->getMessage(),
                'code' => 400
            ]))
            ->response()
            ->setStatusCode(400);
        }
    }
}
