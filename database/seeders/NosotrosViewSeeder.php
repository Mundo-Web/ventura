<?php

namespace Database\Seeders;

use App\Models\NosotrosView;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NosotrosViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NosotrosView::updateOrCreate([
            'id' => 1
        ],[
            'title1section' => 'Con Ventura, estás donde quieres estar',
            'description1section' => 'Con 6 años de experiencia gestionando inmuebles en las mejores zonas de Lima, hemos desarrollado un servicio que responde a la creciente demanda de Airbnbs en la ciudad. Somos un equipo comprometido con crear experiencias de alquiler óptimas, garantizando rentabilidad para nuestros propietarios y máximo confort para nuestros huéspedes.',

            'subtitle3section' => 'Nuestra misión',
            'title3section' => 'Crear recuerdos inolvidables',
            'description3section' => 'Crear experiencias de alquiler óptimas, garantizando rentabilidad para nuestros propietarios y máximo confort para nuestros huéspedes.',

            'subtitle3secondsection' => 'Nuestra meta',
            'title3secondsection' => 'Líderes en alquileres temporales' ,
            'description3secondsection' => 'Ser la opción número uno en alquileres temporales en Lima, reconocidos por nuestro compromiso con la calidad y la satisfacción del cliente.' ,

            'title4section' => 'Conoce a Nuestro Equipo',
            'description4section' => 'Somos un equipo apasionado y comprometido con la excelencia. Cada miembro de nuestro equipo aporta su experiencia y dedicación para asegurar que cada estancia sea perfecta y cada propiedad alcance su máximo potencial.' ,
          
        ]);
    }
}
