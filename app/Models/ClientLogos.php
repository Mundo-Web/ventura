<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLogos extends Model
{
    use HasFactory;
    protected $fillable = ['order','title', 'description', 'url_image', 'url_image2', 'destacar','visible', 'status'];

}
