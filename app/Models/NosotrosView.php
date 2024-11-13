<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NosotrosView extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'title1section', 
        'description1section', 
        'url_image2section',
        'title3section',
        'subtitle3section',
        'description3section',
        'title3secondsection',
        'subtitle3secondsection',
        'description3secondsection',
        'title4section',
        'description4section',
        'url_image4section'
    
    ];
}
