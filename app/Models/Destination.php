<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    
    protected $primaryKey = 'id_destinasi';
    protected $table = 'destination';
    
      protected $fillable = [
        'images',
        'title',
        'rating',
        'trending',
        'location',
        'description',
        'facilities',
    ];

    use HasFactory;
}
