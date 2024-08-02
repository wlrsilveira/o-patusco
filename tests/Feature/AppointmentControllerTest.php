<?php

namespace Tests\Feature;

use App\Models\AnimalType;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class AppointmentControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Criação de um usuário para autenticação
        $this->user = User::factory()->create();
        $this->user->syncRoles(['recepcionist', 'attendant']);
        $this->actingAs($this->user, 'api');
    }

    public function test_list_appointments():void
    {
        Appointment::factory()->create([
            'doctor_id' => $this->user->id,
        ]);

        $response = $this->getJson('/api/v1/appointment');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_store_appointment():void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'animal_name' => 'Rex',
            'animal_type_id' => AnimalType::first()->id,
            'animal_age' => 3,
            'symptoms' => 'Coughing',
            'date' => now()->format('Y-m-d'),
            'period' => 'morning',
        ];

        $response = $this->postJson('/api/v1/appointment', $data);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJsonFragment([
                     'client_name' => 'John Doe',
                     'animal_name' => 'Rex',
                 ]);
    }

    public function test_update_appointment():void
    {
        $appointment = Appointment::factory()->create([
            'doctor_id' => $this->user->id,
        ]);

        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'animal_name' => 'Rex',
            'animal_type_id' => AnimalType::first()->id,
            'animal_age' => 3,
            'symptoms' => 'Coughing',
            'date' => now()->format('Y-m-d'),
            'period' => 'morning',
        ];

        $response = $this->putJson("/api/v1/{$appointment->id}/appointment/", $data);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonFragment([
                     'client_name' => 'John Doe',
                     'animal_name' => 'Rex',
                 ]);
    }

    public function test_show_appointment():void
    {
        $appointment = Appointment::factory()->create([
            'doctor_id' => $this->user->id,
        ]);

        $response = $this->getJson("/api/v1/{$appointment->id}/appointment/");

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonFragment([
                     'id' => $appointment->id,
                     'client_name' => $appointment->name,
                 ]);
    }

    public function test_destroy_appointment():void
    {
        $appointment = Appointment::factory()->create([
            'doctor_id' => $this->user->id,
        ]);

        $response = $this->deleteJson("/api/v1/{$appointment->id}/appointment/");
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_list_by_user()
    {
        $user = User::factory()->create();
        $user->syncRoles('doctor');

        Appointment::factory()->create([
            'doctor_id' => $user->id,
        ]);
        Appointment::factory()->create([
            'doctor_id' => null,
        ]);

        $response = $this->actingAs($user, 'api')
            ->getJson('/api/v1/my/appointments');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(1);

    }

    public function test_update_by_user()
    {
        $user = User::factory()->create();
        $user->syncRoles('doctor');

        $appointment = Appointment::factory()->create([
            'doctor_id' => $user->id,
        ]);
        $secondAppointment = Appointment::factory()->create([
            'doctor_id' => null,
        ]);

        $data = [
            'animal_name' => 'Bella',
        ];

        $response = $this->actingAs($user, 'api')
            ->putJson("/api/v1/my/appointments/{$appointment->id}", $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'animal_name' => 'Bella',
            ]);

        $response = $this->actingAs($user, 'api')
            ->putJson("/api/v1/my/appointments/{$secondAppointment->id}", $data);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
