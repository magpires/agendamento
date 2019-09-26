<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'sobrenome' => 'Admin',
            'email' => 'admin@admin.com',
            'rm' => '0000000001',
            'telefone' => '(00) 00000-0001',
            'tipo' => 'Secretário',
            'password' => Hash::make('aaaaaa'),
        ]);
    }
}
