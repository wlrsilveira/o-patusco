<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ExceptionResource;
use App\Http\Resources\UsersResourceCollection;
use App\Models\User;
use App\Services\Receptionist\ReceptionistService;
use Illuminate\Http\JsonResponse;

/**
 * @group Recepcionist
 */
class RecepcionistController extends Controller
{
    /**
     * Create recepcionist
     * @header Content-Type application/json
     * @header Accept application/json
     * @response 200 {
     *          "id": 1,
     *          "name": "John Doe",
     *          "email": "john.doe@test.com",
     *          "roles": [
     *              {
     *                  "id": 1,
     *                  "name": "Recepcionist",
     *                  "permissions": [
     *                      {
     *                          "id": 1,
     *                          "name": "permissions"
     *                      }
     *                  ]
     *              }
     *          ]
     *}
     * @response 403 {
     *   "message": "Unauthorized"
     * }
     * @apiResourceModel App\Models\User
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        StoreUserRequest $request,
        ReceptionistService $receptionistService
    ): JsonResponse {
        try {
            return response()->json(
                UsersResourceCollection::make(
                    $receptionistService->create(
                        $request->validated()
                    )
                ),
                201
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

    /**
     * Update recepcionist
     * @authenticated
     * @header Content-Type application/json
     * @header Accept application/json
     * @header Authorization Bearer {token}
     * @response 200 {
     *          "id": 1,
     *          "name": "John Doe",
     *          "email": "john.doe@test.com",
     *          "roles": [
     *              {
     *                  "id": 1,
     *                  "name": "Recepcionist",
     *                  "permissions": [
     *                      {
     *                          "id": 1,
     *                          "name": "permissions"
     *                      }
     *                  ]
     *              }
     *          ]
     *}
     * @response 403 {
     *   "message": "Unauthorized"
     * }
     *
     * @apiResourceModel App\Models\User
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        User $user,
        UpdateUserRequest $request,
        ReceptionistService $receptionistService
    ): JsonResponse {
        try {
            return response()->json(
                UsersResourceCollection::make(
                    $receptionistService->update(
                        $user,
                        $request->validated()
                    )
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

    /**
     * Get a specified recepcionist.
     * * @authenticated
     * @header Content-Type application/json
     * @header Accept application/json
     * @header Authorization Bearer {token}
     * @response 200 {
     *          "id": 1,
     *          "name": "John Doe",
     *          "email": "john.doe@test.com",
     *          "roles": [
     *              {
     *                  "id": 1,
     *                  "name": "Recepcionist",
     *                  "permissions": [
     *                      {
     *                          "id": 1,
     *                          "name": "permissions"
     *                      }
     *                  ]
     *              }
     *          ]
     *}
     * @response 403 {
     *   "message": "Unauthorized"
     * }
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        try {
            return response()->json(
                UsersResourceCollection::make(
                    $user
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

    /**
    * Remove the specified recepcionist.
    * @authenticated
    * @header Content-Type application/json
    * @header Accept application/json
    * @header Authorization Bearer {token}
    *
    * @param  \App\Models\User  $user
    * @return \Illuminate\Http\JsonResponse
    */
    public function destroy(
        User $user,
        ReceptionistService $receptionistService
    ) {
        try {
            if ($user->id == auth()->id()) {
                throw new \Exception('Não é possível deletar o usuário logado', 400);
            }

            $receptionistService->delete($user);
            return response()->noContent();
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
