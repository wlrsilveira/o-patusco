<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchUsersRequest;
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

     /**
     * Get a list of attendants.
     * * @authenticated
     * @header Content-Type application/json
     * @header Accept application/json
     * @header Authorization Bearer {token}
     * @response 200 {
     * "data": [
     *     {
     *         "id": 2,
     *         "name": "Atendente",
     *         "email": "atendente@gmail.com",
     *         "roles": [
     *             {
     *                 "id": 1,
     *                 "name": "attendant",
     *                 "permissions": [
     *                     {
     *                         "id": 1,
     *                         "name": "schedule_appointments"
     *                     }
     *                 ]
     *             }
     *         ]
     *     }
     *     ],
     *     "meta": {
     *         "current_page": 1,
     *         "per_page": 1,
     *         "total": 2
     *     }
     * }
     * @response 403 {
     *   "message": "Unauthorized"
     * }
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(
        SearchUsersRequest $request,
        AttendantService $attendantService
    ): JsonResponse {
        try {
            $items = $attendantService->list($request->validated());
            $returnData = [
                'data' => UsersResourceCollection::collection(
                    $items->items()
                ),
                'meta' => [
                    'current_page' => $items->currentPage(),
                    'per_page' => $items->perPage(),
                    'total' => $items->total(),
                ]
            ];

            return response()->json(
                $returnData,
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
