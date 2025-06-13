<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeView extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'title1section', 
        'description1section', 
        'url_image1section',
        'subtitle1section',
        'titledate1section',

        'title2section',
        'description2section',
        'url_image2section',
        'button2section',

        'title3section',
        'description3section',
        'url_image3section',

        'title4section',
        'description4section',
        'url_image4section',
        'button4section',

        'title5section',
        'description5section',
        'footer5section',
        'button5section',

        'title6section',
        'description6section',
        'button6section',
        'address6section',
        'number6section',
        'mail6section',
        'atencion6section',
        
        'title7section',
        'description7section',

        'title8section',
        'description8section',
        'button8section',

        'titledate9section',
        'description9section',
       
    ];
}
