<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomeView;

class HomeViewSecondSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomeView::updateOrCreate([
            'id' => 1
        ],[
           
            'subtitle1section' => 'Propietario, anuncia tu propiedad gratis',
            'titledate1section' => 'Elige unas Fechas',
        
            'button2section' => 'Sobre Nosotros',

            'title8section' => 'Nuestras propiedades',
            'description8section' => 'Conoce acá todas las propiedades exclusivas que tenemos disponibles. Disfruta de una estadía perfecta en las mejores zonas de Lima.',
            'button8section' => 'Ver todos los departamentos',
        
            'button4section' => 'Ponte en contacto',
        
            'button5section' => 'Enviar',
        
            'button6section' => 'Enviar solicitud',
            'address6section' => 'Dirección',
            'number6section' => 'Número de teléfono',
            'mail6section' => 'Correo electrónico',
            'atencion6section' => 'Horario de atención',
        
            'titledate9section' => '¿Tienes un viaje en mente? Escríbenos.',
            'description9section' => '¿Tienes un viaje? Escríbenos si necesitas nuestra ayuda? No dudes en contactarnos.'
        ]);
    }
}
