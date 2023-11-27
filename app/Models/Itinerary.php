<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    protected $primaryKey = 'id_itinerary';
    protected $table = 'itinerary';
    
      protected $fillable = [
        'itinerary_day',
        'itinerary_location_description',
        'itinerary_description',
    ];

    use HasFactory;
}
