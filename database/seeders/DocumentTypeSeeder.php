<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['name' => 'Documento nacional de identidad'],
            ['name' => 'Pasaporte'],
            ['name' => 'Carnet de extranjería'],
            ['name' => 'Otro'],
        ];

        DB::table('document_types')->truncate();
        DB::table('document_types')->insert($types);
    }
}
