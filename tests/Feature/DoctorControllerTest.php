<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class DoctorControllerTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->user->syncRoles(['admin']);
        $this->actingAs($this->user, 'api');
    }

    /**
     * Test creating an attendant
     */
    public function test_store_doctor()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/v1/doctor', $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'name' => 'John Doe',
                'email' => 'john.doe@test.com'
            ]);
    }

    /**
     * Test updating an attendant
     */
    public function test_update_doctor()
    {
        $attendant = User::factory()->create();
        $attendant->syncRoles(['doctor']);

        $data = [
            'name' => 'Jane Doe',
        ];

        $response = $this->putJson("/api/v1/doctor/{$attendant->id}", $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'name' => 'Jane Doe',
            ]);
    }

    /**
     * Test retrieving an attendant
     */
    public function test_index_doctor()
    {
        $attendant = User::factory()->create();

        $response = $this->getJson("/api/v1/doctor/{$attendant->id}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'name' => $attendant->name,
                'email' => $attendant->email
            ]);
    }

    /**
     * Test deleting an attendant
     */
    public function test_destroy_doctor()
    {
        $attendant = User::factory()->create();

        $response = $this->deleteJson("/api/v1/doctor/{$attendant->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('users', ['id' => $attendant->id]);
    }

    /**
     * Test creating an attendant with validation failure
     */
    public function test_store_doctor_validation()
    {
        $response = $this->postJson('/api/v1/doctor', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                 ->assertJsonStructure([
                     'errors' => [
                         'name',
                         'email',
                         'password'
                     ]
                 ]);
    }
}
