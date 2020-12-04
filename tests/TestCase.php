<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $adminRole;
    public $customerRole;
    public $admin;
    public $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminRole = Role::create(['guard_name' => 'api', 'name' => 'admin']);
        $this->customerRole = Role::create(['guard_name' => 'api', 'name' => 'customer']);
        $this->admin = User::factory()->create([
            'email' => 'admin@email.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
        ]);
        $this->customer = User::factory()->create([
            'email' => 'customer@email.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
        ]);

        $this->admin->assignRole($this->adminRole);
        $this->customer->assignRole($this->customerRole);
    }
}
