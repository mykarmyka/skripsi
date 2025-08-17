<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role kalau belum
        Role::firstOrCreate(['name' => 'bidan']);
        Role::firstOrCreate(['name' => 'staff']);

        // Buat user baru
        $admin = User::updateOrCreate([
            'name' => 'Bidan',
            'username' => 'Bidan',
            'password' => Hash::make('bidan123'),
        ]);

        // Assign role ke user
        $admin->assignRole('bidan');

        $staff1 = User::create([
            'name' => 'Staff1',
            'username' => 'Staff1',
            'password' => Hash::make('staff1'),
        ]);

        $staff1->assignRole('staff');

        $staff2 = User::create([
            'name' => 'Staff2',
            'username' => 'Staff2',
            'password' => Hash::make('staff2'),
        ]);

        $staff2->assignRole('staff');
    }
}
