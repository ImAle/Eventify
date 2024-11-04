<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'deleted'
    ];

    // Relación con el modelo Event
    public function events()
    {
        return $this->hasMany(Events::class, 'category_id');
    }
}
