<?php

namespace Database\Seeders;

use App\Models\ClientLogos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadiscticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $beneficios = [

            ['title' => '90%', 'description' => 'Tasa de Ocupación'],
            ['title' => '95%', 'description' => 'Clientes Satisfechos'],
            ['title' => '+20%', 'description' => 'Crecimiento Anual']

        ];

        foreach ($beneficios as $key => $beneficio) {
            ClientLogos::updateOrCreate([
                'id' => $key + 1
            ], $beneficio);
        }
    }
}
