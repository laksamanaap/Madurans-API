<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Itinerary extends Model
{
        protected $primaryKey = 'id_itinerary';
        protected $table = 'itinerary';
        protected $guarded = [];

        protected $fillable = [
            'id_destinasi',
            'itinerary_day',
            'itinerary_location_description',
            'itinerary_description',
        ];

        public function itinerary() :BelongsTo
        {
            return $this->belongsTo(Destination::class, 'id_itinerary', 'id_itinerary');
        }

    use HasFactory;
}
