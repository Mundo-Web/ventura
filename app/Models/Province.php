<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    
    protected $keyType = 'string';
    
    protected $fillable = [        
        'department_id',
        'description',
        'active',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
