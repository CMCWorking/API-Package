<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        $admin = $this->user->create([
            'name' => 'Super Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('123123123'),
        ]);

        $admin->assignRole('Admin');

        $editor = $this->user->create([
            'name' => 'Editor',
            'email' => 'editor@email.com',
            'password' => Hash::make('123123123'),
        ]);

        $editor->assignRole('Editor');
    }
}
