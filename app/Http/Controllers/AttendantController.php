<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ExceptionResource;
use App\Http\Resources\UsersResourceCollection;
use App\Models\User;
use App\Services\Attendant\AttendantService;
use Illuminate\Http\JsonResponse;

/**
 * @group Attendant
 */
class AttendantController extends Controller
{
    /**
     * Create attendant
     * @header Content-Type application/json
     * @header Accept application/json
     * @response 200 {
     *          "id": 1,
     *          "name": "John Doe",
     *          "email": "john.doe@test.com",
     *          "roles": [
     *              {
     *                  "id": 1,
     *                  "name": "Attendant",
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
        AttendantService $attendantService
    ): JsonResponse {
        try {
            return response()->json(
                UsersResourceCollection::make(
                    $attendantService->create(
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
     * Update attendant
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
     *                  "name": "Attendant",
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
        AttendantService $attendantService
    ): JsonResponse {
        try {
            return response()->json(
                UsersResourceCollection::make(
                    $attendantService->update(
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
     * Get a specified attendant.
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
     *                  "name": "Attendant",
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
    * Remove the specified attendant.
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
        AttendantService $attendantService
    ) {
        try {
            if ($user->id == auth()->id()) {
                throw new \Exception('Não é possível deletar o usuário logado', 400);
            }

            $attendantService->delete($user);
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
