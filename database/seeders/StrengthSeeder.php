<?php

namespace Database\Seeders;

use App\Models\Strength;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StrengthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $beneficios = [

            ['titulo' => 'Cuidamos tu departamento como si fuese  nuestro', 'descripcionshort' => '¡Somos aliados confiables!'],
            ['titulo' => 'Creación de anuncios', 'descripcionshort' => 'Publicamos y  optimizamos tu propiedad en distintas  plataformas de alquiler.'],
            ['titulo' => 'Captación y contacto con huéspedes', 'descripcionshort' => 'Gestionamos las reservas y la comunicación  con los huéspedes.'],
            ['titulo' => 'Limpieza y mantenimiento', 'descripcionshort' => 'Nos encargamos  de que todo esté en perfecto estado para  recibir al siguiente huésped.']

        ];

        foreach ($beneficios as $key => $beneficio) {
            Strength::updateOrCreate([
                'id' => $key + 1,
                'status' => true
            ], $beneficio);
        }
    }
}
