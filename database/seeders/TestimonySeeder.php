<?php

namespace Database\Seeders;

use App\Models\Testimony;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonios = [

            ['name' => 'Alejandra Neyra', 'ocupation' => 'Inquilino', 'url_image' => 'images/img/venturauser.png', 'testimonie' => '“La plataforma de Ventura  es a la que acudo casi a diario para buscar donde quedarme para vacaciones, o simplemente para buscar depas de mi sueño en nuevas áreas."'],
            ['name' => 'Diego Martinez', 'ocupation' => 'Inquilino', 'url_image' => 'images/img/venturauser.png', 'testimonie' => '“La plataforma de Ventura  es a la que acudo casi a diario para buscar donde quedarme para vacaciones, o simplemente para buscar depas de mi sueño en nuevas áreas."'],
            ['name' => 'Manuel Gamboa', 'ocupation' => 'Inquilino', 'url_image' => 'images/img/venturauser.png', 'testimonie' => '“La plataforma de Ventura  es a la que acudo casi a diario para buscar donde quedarme para vacaciones, o simplemente para buscar depas de mi sueño en nuevas áreas."']

        ];

        foreach ($testimonios as $key => $testimonio) {
            Testimony::updateOrCreate([
                'id' => $key + 1,
                'visible' => true,
                'status' => true
            ], $testimonio);
        }
    }
}
