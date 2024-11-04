<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

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
