<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\General;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        General::updateOrCreate([
            'id' => 1
        ],[
            'address' => 'Av. Javier Prado',
            'inside' => '4311',
            'district' => 'San Isidro',
            'schedule' => "De Lunes a Viernes de 9:00am a 6:00pm, Sábados de 9:00am a 1:00pm",
            'city' => 'Lima',
            'country' => 'Perú',
            'cellphone' => '555-555-123' ,
            'office_phone' => '5555-1025' ,
            'email' => 'info@ventura.com.pe',
            'facebook' => 'www.facebook.com',
            'instagram' => 'www.instagram.com',
            'youtube' => 'www.youtube.com',
            'twitter' => 'www.twitter.com',
            'whatsapp' => '555-555-123' ,
            'form_email' => 'info@ventura.com.pe',
            'business_hours' => 'horas',
            'mensaje_whatsapp' => 'Hola estamos atentos a lo que ud desee',
            'htop' =>'Descubre los mejores productos y promociones en Deco Tab',
            'aboutus' => 'Somos una empresa dedicada a la gestión integral de propiedades de lujo en Lima, ofreciendo una experiencia inigualable tanto para huéspedes como para propietarios.'
        ]);
    }
}
