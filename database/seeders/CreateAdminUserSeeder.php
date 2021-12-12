<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder{
    /*** Run the database seeds.
     ** @return void*/
    public function run(){
        $user = User::create([
            'name' => 'admin admin',
            'email' => 'admin2@admin.com',
            'password' => bcrypt('123456'),
            'role_name' => ['owner'],
            'status' => 'مقعل'
        ]);
        $role = Role::create(['name' => 'owner']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}