<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationImage extends Model
{

    protected $primaryKey = 'id_destination_images';
    protected $table = 'destination_image';
    protected $guarded = [];

    protected function Photo(): Attribute
    {
        if (property_exists((object) $this->attributes, 'icon')) {
            if ($this->attributes['icon']) {
                return Attribute::make(
                    get: fn ($value) => Storage::disk('public')->url($this->attributes['icon'])
                );
            } else {
                return Attribute::make(
                    get: fn ($value) => null
                );
            }
        } else {
            return Attribute::make(
                get: fn ($value) => null
            );
        }
    }


    public function destination() :BelongsTo
    {
        return $this->belongsTo(Destination::class, 'id_destinasi', 'id_destinasi');
    }

    use HasFactory;
}
