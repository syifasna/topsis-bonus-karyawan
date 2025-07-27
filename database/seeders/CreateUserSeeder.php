<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
               'name'=>'Annisa Frida',
               'email'=>'admin1@delibra.com',
               'type'=>1,
               'password'=> bcrypt('admin1'),
            ],
            [
                'name'=>'Hani Yosinata',
                'email'=>'admi2n@delibra.com',
                'type'=>1,
                'password'=> bcrypt('admin2'),
             ],
            [
               'name'=>'Rifat',
               'email'=>'owner@delibra.com',
               'type'=> 2,
               'password'=> bcrypt('owner123'),
            ],
            [
               'name'=>'user',
               'email'=>'user@delibra.com',
               'type'=>0,
               'password'=> bcrypt('user00'),
            ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
