<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class rolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

        public function run(): void
    {/*
        $roleEntity=[];

        $roles = ["Admin","ZooKeeper","DeskWorker","Visitor"];

        $permissionsZooKeeper=['animal-list','animal-create','animal-edit','animal-delete','task-list',"user-list","event-list"];
        $permissionsDeskWorker=['event-list','event-create','event-edit','event-delete','task-list','task-create','task-edit','task-delete','zone-list','zone-create','zone-edit','zone-delete'];
        $permissionsVisitor=["animal-list","event-list","zone-list"];

        $user = User::create([
            'name' => 'Isai',
            'email' => 'admin@me.com',
            'password' => bcrypt('password'),
            "phone" => "631520315",
            "type" => 1
        ]);

        foreach ($roles as $role) {
            $roleEntity[] = Role::create(['name' => $role,'guard_name'=>'api']);
        }

        $rdyPermAdmi = Permission::pluck('id','id')->all();
        $rdyPerZoo =  Permission::whereIn('name', $permissionsZooKeeper)->pluck('id', 'id')->all();
        $rdyPerDesk =  Permission::whereIn('name', $permissionsDeskWorker)->pluck('id', 'id')->all();
        $rdyPerVis = Permission::whereIn('name', $permissionsVisitor)->pluck('id', 'id')->all();

        $roleEntity[0]->syncPermissions($rdyPermAdmi);
        $roleEntity[1]->syncPermissions($rdyPerZoo);
        $roleEntity[2]->syncPermissions($rdyPerDesk);
        $roleEntity[3]->syncPermissions($rdyPerVis);*/

        $editorRole = Role::findByName('DeskWorker','api');

        $permissionsDeskWorker=['user-list','event-list','event-create','event-edit','event-delete','task-list','task-create','task-edit','task-delete','zone-list','zone-create','zone-edit','zone-delete'];

        $rdyPerDesk =  Permission::whereIn('name', $permissionsDeskWorker)->pluck('id', 'id')->all();

        $editorRole->syncPermissions($permissionsDeskWorker);
    }
}
