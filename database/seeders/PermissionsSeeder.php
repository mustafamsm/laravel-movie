<?php

namespace Database\Seeders;

use App\Models\User;
use Termwind\Components\Hr;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();







        //create permissions
        Permission::create(['name' => 'create movies']);
        Permission::create(['name' => 'edit movies']);
        Permission::create(['name' => 'delete movies']);
        Permission::create(['name' => 'show movies']);

        Permission::create(['name' => 'create tvShows']);
        Permission::create(['name' => 'edit tvShows']);
        Permission::create(['name' => 'delete tvShows']);
        Permission::create(['name' => 'show tvShows']);

        Permission::create(['name' => 'create seasons']);
        Permission::create(['name' => 'edit seasons']);
        Permission::create(['name' => 'delete seasons']);
        Permission::create(['name' => 'show seasons']);

        Permission::create(['name' => 'create episodes']);
        Permission::create(['name' => 'edit episodes']);
        Permission::create(['name' => 'delete episodes']);
        Permission::create(['name' => 'show episodes']);

        Permission::create(['name' => 'create genres']);
        Permission::create(['name' => 'edit genres']);
        Permission::create(['name' => 'delete genres']);
        Permission::create(['name' => 'show genres']);




        Permission::create(['name' => 'create cast']);
        Permission::create(['name' => 'edit cast']);
        Permission::create(['name' => 'delete cast']);
        Permission::create(['name' => 'show cast']);

        Permission::create(['name' => 'create tags']);
        Permission::create(['name' => 'edit tags']);
        Permission::create(['name' => 'delete tags']);
        Permission::create(['name' => 'show tags']);

        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'show users']);

        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);
        Permission::create(['name' => 'show roles']);

        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'edit permissions']);
        Permission::create(['name' => 'delete permissions']);
        Permission::create(['name' => 'show permissions']);

        Permission::create(['name' => 'create trailers']);
        Permission::create(['name' => 'edit trailers']);
        Permission::create(['name' => 'delete trailers']);
        Permission::create(['name' => 'show trailers']);

        Permission::create(['name' => 'create downloads']);
        Permission::create(['name' => 'edit downloads']);
        Permission::create(['name' => 'delete downloads']);
        Permission::create(['name' => 'show downloads']);

        Permission::create(['name' => 'create settings']);
        Permission::create(['name' => 'edit settings']);
        Permission::create(['name' => 'delete settings']);
        Permission::create(['name' => 'show settings']);


        //create roles and assign existing permissins
        
        $role1=Role::create(['name'=>'admin']);

        $role1->givePermissionTo([
            'create movies',
            'edit movies',
            'delete movies',
            'show movies',

            'create tvShows',
            'edit tvShows',
            'delete tvShows',
            'show tvShows',

            'create seasons',
            'edit seasons',
            'delete seasons',
            'show seasons',

            'create episodes',
            'edit episodes',
            'delete episodes',
            'show episodes',

            'create genres',
            'edit genres',
            'delete genres',
            'show genres',

            'create cast',
            'edit cast',
            'delete cast',
            'show cast',

            'create tags',
            'edit tags',
            'delete tags',
            'show tags',

            'create trailers',
            'edit trailers',
            'delete trailers',
            'show trailers',

            'create downloads',
            'edit downloads',
            'delete downloads',
            'show downloads',
           
        ]);


        $role2=Role::create(['name'=>'editor']);
        $role2->givePermissionTo([
          
            'edit movies',
           
            'show movies',

          
            'edit tvShows',
          
            'show tvShows',

          
            'edit seasons',
           
            'show seasons',

         
            'edit episodes',
         
            'show episodes',

            
            'edit genres',
           
            'show genres',

           
            'edit cast',
         
            'show cast',

          
            'edit tags',
     
            'show tags',

       
            'edit trailers',
         
            'show trailers',

          
            'edit downloads',
           
            'show downloads',
        ]);

        $role3=Role::create(['name'=>'user']);
        $role3->givePermissionTo([
          
            'show movies',

          
            'show tvShows',

           
            'show seasons',

         
            'show episodes',

           
            'show genres',

           
            'show cast',

          
            'show tags',

       
            'show trailers',

          
            'show downloads',
        ]);

        $role4 = Role::create(['name' => 'Super-Admin']);

        $user=User::create([
            'name'=>'super Admin',
           'email'=>'super-admin@admin.com',
           'password'=>Hash::make('password')
        ]);
        $user->assignRole($role4);

         $user2=User::create([
            'name'=>' Admin',
           'email'=>'admin@admin.com',
           'password'=>Hash::make('password')
        ]);
        $user2->assignRole($role1);

        $user3=User::create([
            'name'=>'user',
           'email'=>'user@user.com',
           'password'=>Hash::make('password')
        ]);
        $user3->assignRole($role3);
      

        $user4=User::create([
            'name'=>'editor',
           'email'=>'editor@user.com',
           'password'=>Hash::make('password')
        ]);
        $user4->assignRole($role2);
         









      


        


       

    }
}
