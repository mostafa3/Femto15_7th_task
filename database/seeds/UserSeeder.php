<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = [
        'name' => 'admin',
        'email' => 'admin@admin.com',
        'password' => bcrypt('admin'),
      ];

      \App\User::firstOrCreate($user);
    }
}
