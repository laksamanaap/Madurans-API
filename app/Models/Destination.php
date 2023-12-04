<?php

namespace App\Models;

use App\Models\Review;
use App\Models\Facilities;
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
        'id_itinerary',
        'images',
        'title',
        'rating',
        'trending',
        'location',
        'description',
        'facilities',
    ];

    public function itinerary() :HasMany
    {
        return $this->hasMany(Itinerary::class, 'id_destinasi', 'id_destinasi');
    }

    public function review() :HasMany
    {
        return $this->hasMany(Review::class, 'id_destinasi', 'id_destinasi');
    }

    public function facilities(): HasMany
    {
        return $this->hasMany(Facilities::class, 'id_destinasi', 'id_destinasi');
    }

    use HasFactory;
}
