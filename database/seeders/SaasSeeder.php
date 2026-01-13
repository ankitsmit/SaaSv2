<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Module;
use App\Models\Submodule;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SaasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'user_type' => 'super_admin',
            ]
        );

        // Create Sample Company
        $company = Company::firstOrCreate(
            ['slug' => 'sample-company'],
            [
                'name' => 'Sample Company',
                'email' => 'company@example.com',
                'is_active' => true,
            ]
        );

        // Create Sample Client User
        $client = User::firstOrCreate(
            ['email' => 'client@example.com'],
            [
                'name' => 'Client User',
                'password' => Hash::make('password'),
                'user_type' => 'client',
                'company_id' => $company->id,
            ]
        );

        // Create Sample Module
        $module = Module::firstOrCreate(
            ['slug' => 'example-module'],
            [
                'name' => 'Example Module',
                'icon' => 'dashboard',
                'description' => 'This is an example module',
                'is_active' => true,
                'order' => 1,
            ]
        );

        // Create Sample Submodule
        $submodule = Submodule::firstOrCreate(
            ['module_id' => $module->id, 'slug' => 'example-submodule'],
            [
                'name' => 'Example Submodule',
                'route' => 'client.example',
                'icon' => 'dashboard',
                'description' => 'This is an example submodule',
                'is_active' => true,
                'order' => 1,
            ]
        );

        // Assign Module to Company
        if (!$company->modules->contains($module->id)) {
            $company->modules()->attach($module->id, ['is_active' => true]);
        }
        
        if (!$company->submodules->contains($submodule->id)) {
            $company->submodules()->attach($submodule->id, ['is_active' => true]);
        }

        // Create Permissions
        $permission = Permission::firstOrCreate(
            ['slug' => 'view-example'],
            [
                'name' => 'View Example',
                'type' => 'submodule',
                'submodule_id' => $submodule->id,
            ]
        );
    }
}
