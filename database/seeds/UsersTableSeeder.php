<?php

use Illuminate\Database\Seeder;
use App\User;//adiciona  a classe user

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     //criar dados 
     User::create([
        'name'     => 'Anderson',
        'email'    => 'anderson_silvaribeiro@hotmail.com',
        'password' => bcrypt('123456'),
     ]);
     User::create([
        'name'     => 'Silva',
        'email'    => 'andersonsilvaribeiro@gmail.com',
        'password' => bcrypt('123456'),
     ]);
          
    }
}
