<?php

use Illuminate\Database\Seeder;
use App\Applications\User\Model\User;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var User $Admin */
        $Admin = User::create([
            'id' => 1,
            'username' => 'administrator',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'is_disabled' => 0,
            'password' => bcrypt('password'),
        ]);
        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);

        /** @var User $Colaborator */
        $Colaborator = User::create([
            'id' => 2,
            'username' => 'collaborator',
            'first_name' => 'Collaborator',
            'last_name' => 'User',
            'email' => 'collaborator@example.com',
            'is_disabled' => 0,
            'password' => bcrypt('password'),
        ]);
        DB::table('role_user')->insert([
            'user_id' => 2,
            'role_id' => 2,
        ]);

        /** @var User $Public */
        $Public = User::create([
            'id' => 3,
            'username' => 'public',
            'first_name' => 'Public',
            'last_name' => 'User',
            'company' => 'Company',
            'email' => 'public@example.com',
            'is_disabled' => 0,
            'password' => bcrypt('password'),
        ]);
        DB::table('role_user')->insert([
            'user_id' => 3,
            'role_id' => 3,
        ]);


        try {
            $Admin->addMedia(public_path() . '/images/avatar.jpg')->preservingOriginal()->toMediaCollection('user_avatars');
            $Colaborator->addMedia(public_path() . '/images/avatar.jpg')->preservingOriginal()->toMediaCollection('user_avatars');
            $Public->addMedia(public_path() . '/images/avatar.jpg')->preservingOriginal()->toMediaCollection('user_avatars');
        } catch (Exception $e) {
            echo ($e);
        }
    }
}
