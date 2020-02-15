<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('book')->insert([
            // [
            //     'title' => 'Código Limpo',
            //     'loan_amount' => 1,
            //     'remaining_amount' => 1,
            //     'total' => 1,
            // ],
            [
                'title' => 'Equipes de Software',
                'loan_amount' => 1,
                'remaining_amount' => 1,
                'total' => 1,
            ],
            [
                'title' => 'A Arte de Escrever Códigos Legíveis',
                'loan_amount' => 1,
                'remaining_amount' => 1,
                'total' => 1,
            ],
        ]);
    }
}
