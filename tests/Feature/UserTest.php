<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMockingConsoleOutput();
        $this->withoutExceptionHandling();
        $this->artisan('passport:install');
    }

    public function test_a_user_can_login()
    {
        $this->withoutExceptionHandling();
        $payload = [
            'email' => $this->admin->email,
            'password' => 'password',
        ];

        $response = $this->postJson(route('user.login'), $payload);
        $response->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);
    }

    public function test_an_admin_can_view_user()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->admin);

        $response = $this->getJson(route('admin.user.show', ['user' => $this->admin->id]));
        $response->assertJsonStructure([
            'data' => ['id']
        ]);
        $response->assertJsonFragment([
            'id' => $this->admin->id
        ]);

        $response = $this->getJson(route('admin.user.show', ['user' => $this->customer->id]));
        $response->assertJsonStructure([
            'data' => ['id']
        ]);
        $response->assertJsonFragment([
            'id' => $this->customer->id
        ]);
    }

    public function test_an_admin_can_add_new_user()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->admin);
        $roles = ['admin', 'customer'];
        $password = $this->faker->password;
        $payload = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $password,
            'password_confirmation' => $password,
            'role' => $roles[random_int(0, 1)],
        ];

        $response = $this->postJson(route('admin.user.store'), $payload);
        $response->assertJsonStructure([
            'data' => ['id', 'name']
        ]);
    }

    public function test_an_admin_can_update_user_profile()
    {
        $this->withoutExceptionHandling();
        Passport::actingAs(
            $this->admin
        );
        // $this->actingAs($this->admin);
        $updated_name = $this->faker->name;
        $roles = ['admin', 'customer'];
        $role = $roles[random_int(0, 1)];
        $payload = [
            'name' => $updated_name,
            'email' => $this->customer->email,
            'whatsapp' => $this->faker->phoneNumber,
            'phone_number' => $this->faker->phoneNumber,
            'role' => $role,
        ];

        $response = $this->putJson(route('admin.user.update', ['user' => $this->customer->id]), $payload);
        $response->assertJsonFragment([
            'name' => $updated_name
        ]);
        $response->assertJsonStructure([
            'data' => ['id', 'email']
        ]);
        $update_user = User::find($this->customer->id);
        self::assertTrue($update_user->hasRole($role));
    }
}
