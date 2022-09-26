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
             'id' => 1,
             'name' => 'Prueba',
             'surname' => 'Prueba',
             'dni' => '123456789L',
             'phone' => '123456789',
             'country' => 'España',
             'IBAN' => ' ES91 2100 0418 45 0200051332',
             'about' => 'Sobre mi',
             'email' => 'seguridadweb@campusviu.es',
             'password' => Hash::make('S3gur1d4d?W3b')
             

         ]);
    }
}
