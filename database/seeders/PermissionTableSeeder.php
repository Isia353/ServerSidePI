<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'animal-list',
            'animal-create',
            'animal-edit',
            'animal-delete',
            'event-list',
            'event-create',
            'event-edit',
            'event-delete',
            'task-list',
            'task-create',
            'task-edit',
            'task-delete',
            'zone-list',
            'zone-create',
            'zone-edit',
            'zone-delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission,'guard_name'=>'api']);
        }
    }
}
