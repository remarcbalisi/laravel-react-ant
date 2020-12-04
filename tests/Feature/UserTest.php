<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

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
            'email' => $this->customer->email,
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
}
