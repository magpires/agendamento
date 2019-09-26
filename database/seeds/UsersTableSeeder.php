<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'André Cypriano',
            'email' => 'amonteiro@gmail.com',
            'rm' => '4568154614',
            'telefone' => '(27) 94128-4962',
            'curso' => 'Sistemas de Informação',
            'id_orientador' => '1',
            'tipo' => 'Orientador',
            'password' => Hash::make('aaaaaa'),
        ]);
    }
}
