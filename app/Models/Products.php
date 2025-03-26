<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
  use HasFactory;
  protected $fillable = [
    'producto',
    'precio',
    'pms',
    'descuento',
    'preciolimpieza',
    'precioservicio',
    'preciobase',
    'preciomin',
    'stock',
    'imagen',
    'imagen_2',
    'imagen_3',
    'imagen_4',
    'imagen_ambiente',
    'destacar',
    'recomendar',
    'atributes',
    'visible',
    'status',
    'extract',
    'description',
    'costo_x_art',
    'peso',
    'categoria_id',
    'subcategory_id',
    'color',
    'image_texture',
    'slug',
    'sku',
    'max_stock', 
    'precio_reseller',
    'cuartos',
    'pisos',
    'movilidad',
    'banios',
    'area',
    'address',
    'inside',
    'district',
    'city',
    'country',
    'frecuencia',
    'cochera',
    'mascota',
    'mobiliado',
    'incluye',
    'no_incluye',
    'disponible',
    'no_disponible',
    'departamento_id',
    'provincia_id',
    'distrito_id',
    'calendar_url',
    'airbnb_url',
    'meta_title', 
    'meta_description', 
    'meta_keywords',
    'latitud',
    'longitud',

  ];
  
  public function events()
  {
    return $this->hasMany(Event::class);
  }

  
  public function categoria()
  {
    return Category::find($this->categoria_id);
  }
  public function category()
  {
    return $this->belongsTo(Category::class, 'categoria_id');
  }

  public function subcategory()
  {
    return SubCategory::find($this->subcategory_id);
  }

  public function galeria()
  {
    return $this->hasMany(Galerie::class, 'product_id');
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class, 'tags_xproducts', 'producto_id', 'tag_id');
  }

  public function scopeActiveDestacado($query)
  {
    return $query->where('status', true)->where('destacar', true);
  }

  public function attributeValues()
  {
    return $this->hasMany(AttributeProductValues::class);
  }

  public function attributes()
  {
    return $this->belongsToMany(Attributes::class, 'attribute_product_values', 'product_id', 'attribute_id')
      ->withPivot('attribute_value_id');
  }
  public function wishedByUsers()
  {
    return $this->hasMany(Wishlist::class, 'product_id');
  }

  public function distrito()
  {
    return $this->belongsTo(District::class, 'distrito_id');
  }

 
}
