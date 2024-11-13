<?php

namespace Database\Seeders;

use App\Models\HomeView;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomeView::updateOrCreate([
            'id' => 1
        ],[
            'title1section' => 'Propiedades que inspiran, experiencias que marcan la diferencia.',
            'description1section' => 'Ahora puedes disfrutar de Lima de la mejor manera a través de nuestras propiedades exclusivas.',
            'url_image1section' => 'url_de_la_imagen_1',

            'title2section' => 'Con Ventura, estás donde quieres estar',
            'description2section' => 'Con 6 años de experiencia gestionando inmuebles en las mejores zonas de Lima, hemos desarrollado un servicio que responde a la creciente demanda de Airbnbs en la ciudad. Somos un equipo comprometido con crear experiencias de alquiler óptimas, garantizando rentabilidad para nuestros propietarios y máximo confort para nuestros huéspedes.',
            'url_image2section' => 'url_de_la_imagen_2', 

            'title3section' => 'Lo que dicen nuestros clientes',
            'description3section' => 'Descubre lo que nuestros huéspedes y propietarios opinan de nuestro servicio.',
            'url_image3section' => 'url_de_la_imagen_3', 

            'title4section' => 'Gestionar tu propiedad de alquiler a corto plazo ahora es más fácil.',
            'description4section' => 'Más rentabilidad, menos estrés. Te ayudamos a maximizar tus ingresos y disfrutar de los beneficios de alquilar tu propiedad sin estrés.',
            'url_image4section' => 'url_de_la_imagen_4', 

            'title5section' => '¿Quieres que pongamos tu propiedad en alquiler?',
            'description5section' => 'Comparte aquí tu correo electrónico y te daremos más información.',
            'footer5section' => 'Únete a 10,000+ propietarios más en nuestra comunidad inmobiliaria.',

            'title6section' => '¿Tienes alguna pregunta o necesitas más información?',
            'description6section' => 'Llena este formulario y nos pondremos en contacto contigo.',

            'title7section' => '¡Conversemos!',
            'description7section' => 'Para cualquier duda o consulta, ponte en contacto con nosotros.'
          
        ]);
    }
}
