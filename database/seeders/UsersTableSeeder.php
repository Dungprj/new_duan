<?php

namespace Database\Seeders;

use App\Models\Utility;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // danh sách các quyền

        $allPermissions = [

            [
                'name' => 'Manage User',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Create User',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Edit User',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Delete User',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Create Permission',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Manage Permission',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Delete Permission',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Edit Permission',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Create Role',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Manage Role',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Edit Role',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Delete Role',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],


            [
                'name' => 'Manage Category',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            [
                'name' => 'Create Category',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            [
                'name' => 'Edit Category',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Delete Category',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Manage Blog',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            [
                'name' => 'Create Blog',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            [
                'name' => 'Edit Blog',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Delete Blog',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],




        ];


        Permission::insert($allPermissions);

        $super_admin_permissions = [
            ['name' => 'Manage User'],
            ['name' => 'Create User'],
            ['name' => 'Edit User'],
            ['name' => 'Delete User'],
            ['name' => 'Create Role'],
            ['name' => 'Manage Role'],
            ['name' => 'Edit Role'],
            ['name' => 'Delete Role'],
            ['name' => 'Manage Permission'],
            ['name' => 'Create Permission'],
            ['name' => 'Edit Permission'],
            ['name' => 'Delete Permission'],

            ['name' => 'Manage Category'],
            ['name' => 'Create Category'],
            ['name' => 'Edit Category'],
            ['name' => 'Delete Category'],

            ['name' => 'Manage Blog'],
            ['name' => 'Create Blog'],
            ['name' => 'Edit Blog'],
            ['name' => 'Delete Blog'],
        ];




        $super_admin_role             = new Role();
        $super_admin_role->name       = 'Admin';
        $super_admin_role->save();

        $super_admin_role ->givePermissionTo($super_admin_permissions);

        $super_admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'status' => 'active',
                'password' => bcrypt('2003'),
            ]);

        $super_admin->assignRole($super_admin_role);



        // ----- author----------
        $author_permissions = [
            ['name' => 'Manage Category'],
            ['name' => 'Create Category'],
            ['name' => 'Manage Blog'],
            ['name' => 'Create Blog'],
            ['name' => 'Edit Blog'],
            ['name' => 'Delete Blog'],
          ];

        $author_role             = new Role();
        $author_role->name       = 'Author';
        $author_role->save();

        $author_role ->givePermissionTo($author_permissions);



        $author = User::create([
                'name' => 'author',
                'email' => 'author@gmail.com',
                'status' => 'active',

                'password' => bcrypt('2003'),
            ]);

        $author->assignRole($author_role);










        // ----------------
        $guest_role             = new Role();
        $guest_role->name       = 'Guest';
        $guest_role->save();



        $guest = User::create([
                'name' => 'guest',
                'email' => 'guest@gmail.com',
                'status' => 'active',

                'password' => bcrypt('2003'),
            ]);

        $guest->assignRole($guest_role);



    }
}
