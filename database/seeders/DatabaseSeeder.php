<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

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
