<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Destination extends Model
{
    
    protected $primaryKey = 'id_destinasi';
    protected $table = 'destination';
    protected $guarded = [];

    
      protected $fillable = [
        'images',
        'title',
        'rating',
        'trending',
        'location',
        'description',
        'facilities',
    ];

    public function itinerary_list() :HasMany
    {
        return $this->hasMany(Itinerary::class, 'id_itinerary', 'id_itinerary');
    }

    use HasFactory;
}
