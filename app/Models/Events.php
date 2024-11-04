<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Events extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organizer_id',
        'title',
        'description',
        'category_id',
        'start_time',
        'end_time',
        'location',
        'latitude',
        'longitude',
        'max_attendees',
        'price',
        'image_url',
        'deleted'
    ];

    protected $dates = ['start_time', 'end_time'];

    // Relación con el modelo User (organizador)
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    // Relación con el modelo Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
