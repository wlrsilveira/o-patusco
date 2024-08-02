<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchAppointmentRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentsResourceCollection;
use App\Http\Resources\ExceptionResource;
use App\Models\Appointment;
use App\Models\User;
use App\Services\Appointment\AppointmentService;
use Illuminate\Http\JsonResponse;

/**
 * @group Appointment
 */
class AppointmentController extends Controller
{
    /**
     * Get a list of appointment.
     * * @authenticated
     * @header Content-Type application/json
     * @header Accept application/json
     * @header Authorization Bearer {token}
     * @response 200 [
     *        {
     *         "id": 1,
     *         "client_name": "John Doe",
     *         "client_email": "email@test.com",
     *         "animal_name": "animal 1",
     *         "animal_type": "cachorro"
     *         "animal_age": 2,
     *         "symptoms": "sintomas",
     *         "date": "2021-10-10",
     *         "period": "manhã",
     *         "doctor": {
     *              "id": 1,
     *              "name": "John Doe",
     *              "email": "test@test.com",
     *          }
     *       },
     *       {
     *         "id": 2,
     *         "client_name": "John Doe",
     *         "client_email": "email@test.com",
     *         "animal_name": "animal 1",
     *         "animal_type": "cachorro"
     *         "animal_age": 2,
     *         "symptoms": "sintomas",
     *         "date": "2021-10-10",
     *         "period": "manhã",
     *         "doctor": {
     *              "id": 1,
     *              "name": "John Doe",
     *              "email": "test@test.com",
     *          }
     *       },
     *]
     * @response 403 {
     *   "message": "Unauthorized"
     * }
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(
        SearchAppointmentRequest $request,
        AppointmentService $appointmentService
    ): JsonResponse {
        try {
            return response()->json(
                AppointmentsResourceCollection::collection(
                    $appointmentService->search(
                        $request->all()
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
     * Create appointment
     * @header Content-Type application/json
     * @header Accept application/json
     * @response 200 {
     *         "id": 1,
     *         "client_name": "John Doe",
     *         "client_email": "email@test.com",
     *         "animal_name": "animal 1",
     *         "animal_type": "cachorro"
     *         "animal_age": 2,
     *         "symptoms": "sintomas",
     *         "date": "2021-10-10",
     *         "period": "manhã",
     *         "doctor": {
     *              "id": 1,
     *              "name": "John Doe",
     *              "email": "test@test.com",
     *          }
     *}
     * @response 403 {
     *   "message": "Unauthorized"
     * }
     * @apiResourceModel App\Models\Appointment
     * @param  \App\Http\Requests\StoreAppointmentRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        StoreAppointmentRequest $request,
        AppointmentService $appointmentService
    ): JsonResponse {
        try {
            return response()->json(
                AppointmentsResourceCollection::make(
                    $appointmentService->create(
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
     * Update appointment
     * @authenticated
     * @header Content-Type application/json
     * @header Accept application/json
     * @header Authorization Bearer {token}
     * @response 200 {
     *         "id": 1,
     *         "client_name": "John Doe",
     *         "client_email": "email@test.com",
     *         "animal_name": "animal 1",
     *         "animal_type": "cachorro"
     *         "animal_age": 2,
     *         "symptoms": "sintomas",
     *         "date": "2021-10-10",
     *         "period": "manhã",
     *         "doctor": {
     *              "id": 1,
     *              "name": "John Doe",
     *              "email": "test@test.com",
     *          }
     *}
     * @response 403 {
     *   "message": "Unauthorized"
     * }
     *
     * @apiResourceModel App\Models\Appointment
     * @param  \App\Http\Requests\UpdateAppointmentRequest  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        Appointment $appointment,
        UpdateAppointmentRequest $request,
        AppointmentService $appointmentService
    ): JsonResponse {
        try {
            return response()->json(
                AppointmentsResourceCollection::make(
                    $appointmentService->update(
                        $appointment,
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
     * Get a specified appointment.
     * * @authenticated
     * @header Content-Type application/json
     * @header Accept application/json
     * @header Authorization Bearer {token}
     * @response 200 {
     *         "id": 1,
     *         "client_name": "John Doe",
     *         "client_email": "email@test.com",
     *         "animal_name": "animal 1",
     *         "animal_type": "cachorro"
     *         "animal_age": 2,
     *         "symptoms": "sintomas",
     *         "date": "2021-10-10",
     *         "period": "manhã",
     *         "doctor": {
     *              "id": 1,
     *              "name": "John Doe",
     *              "email": "test@test.com",
     *          }
     *}
     * @response 403 {
     *   "message": "Unauthorized"
     * }
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Appointment $appointment): JsonResponse
    {
        try {
            return response()->json(
                AppointmentsResourceCollection::make(
                    $appointment
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
    * Remove the specified appointment.
    * @authenticated
    * @header Content-Type application/json
    * @header Accept application/json
    * @header Authorization Bearer {token}
    *
    * @param  \App\Models\Appointment  $appointment
    * @return \Illuminate\Http\JsonResponse
    */
    public function destroy(
        Appointment $appointment,
        AppointmentService $appointmentService
    ) {
        try {
            $appointmentService->delete($appointment);
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
     * Consider doctor appointments
     * @authenticated
     * @header Content-Type application/json
     * @header Accept application/json
     * @header Authorization Bearer {token}
     * @response 200 {
     *         "id": 1,
     *         "client_name": "John Doe",
     *         "client_email": "email@test.com",
     *         "animal_name": "animal 1",
     *         "animal_type": "cachorro"
     *         "animal_age": 2,
     *         "symptoms": "sintomas",
     *         "date": "2021-10-10",
     *         "period": "manhã",
     *         "doctor": {
     *              "id": 1,
     *              "name": "John Doe",
     *              "email": "test@test.com",
     *          }
     *}
     * @response 403 {
     *   "message": "Unauthorized"
     * }
     *
     * @apiResourceModel App\Models\Appointment
     * @param  \App\Http\Requests\UpdateAppointmentRequest  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\JsonResponse
     */
    public function attach(
        Appointment $appointment,
        User $user,
        AppointmentService $appointmentService
    ): JsonResponse {
        try {
            return response()->json(
                AppointmentsResourceCollection::make(
                    $appointmentService->attach(
                        $appointment,
                        $user
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
     * List Appointments by user.
     * * @authenticated
     * @header Content-Type application/json
     * @header Accept application/json
     * @header Authorization Bearer {token}
     * @response 200 [
     *  {
     *         "id": 1,
     *         "client_name": "John Doe",
     *         "client_email": "email@test.com",
     *         "animal_name": "animal 1",
     *         "animal_type": "cachorro"
     *         "animal_age": 2,
     *         "symptoms": "sintomas",
     *         "date": "2021-10-10",
     *         "period": "manhã",
     *         "doctor": {
     *              "id": 1,
     *              "name": "John Doe",
     *              "email": "test@test.com",
     *          }
     *  },
     *{
     *         "id": 2,
     *         "client_name": "John Doe",
     *         "client_email": "email@test.com",
     *         "animal_name": "animal 1",
     *         "animal_type": "cachorro"
     *         "animal_age": 2,
     *         "symptoms": "sintomas",
     *         "date": "2021-10-10",
     *         "period": "manhã",
     *         "doctor": {
     *              "id": 1,
     *              "name": "John Doe",
     *              "email": "test@test.com",
     *          }
     *  },
     * ]
     * @response 403 {
     *   "message": "Unauthorized"
     * }
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\JsonResponse
     */
    public function listByUser()
    {
        try {
            $user = auth()->user();
            return response()->json(
                AppointmentsResourceCollection::collection(
                    $user->appointments
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
     * Update appointment by doctor
     * @authenticated
     * @header Content-Type application/json
     * @header Accept application/json
     * @header Authorization Bearer {token}
     * @response 200 {
     *         "id": 1,
     *         "client_name": "John Doe",
     *         "client_email": "email@test.com",
     *         "animal_name": "animal 1",
     *         "animal_type": "cachorro"
     *         "animal_age": 2,
     *         "symptoms": "sintomas",
     *         "date": "2021-10-10",
     *         "period": "manhã",
     *         "doctor": {
     *              "id": 1,
     *              "name": "John Doe",
     *              "email": "test@test.com",
     *          }
     *}
     * @response 403 {
     *   "message": "Unauthorized"
     * }
     *
     * @apiResourceModel App\Models\Appointment
     * @param  \App\Http\Requests\UpdateAppointmentRequest  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateByUser(
        Appointment $appointment,
        AppointmentService $appointmentService,
        UpdateAppointmentRequest $request
    ): JsonResponse {
        try {
            $user = auth()->user();

            if ($appointment->doctor_id !== $user->id) {
                return response()->json(
                    [
                        'message' => 'Você não tem permissão para editar esta Consulta.',
                        'code' => 403
                    ],
                    403
                );
            }

            return response()->json(
                AppointmentsResourceCollection::make(
                    $appointmentService->update(
                        $appointment,
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


}
