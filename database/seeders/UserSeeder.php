<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        $table = DB::table('users');
        $rows = [
            ['name' => 'Fred', 'email' => 'fred@gmail.com', 'password' => Hash::make('password')],
            ['name' => 'John', 'email' => 'john@gmail.com', 'password' => Hash::make('password')],
            ['name' => 'Drey', 'email' => 'drey@gmail.com', 'password' => Hash::make('password')],
            ['name' => 'Quill', 'email' => 'quill@gmail.com', 'password' => Hash::make('password')],
            ['name' => 'Tom', 'email' => 'tom@gmail.com', 'password' => Hash::make('password')]
        ];
        $table->insert($rows);
    }
}
