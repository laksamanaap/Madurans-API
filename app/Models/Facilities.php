<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facilities extends Model
{

    protected $primaryKey = 'id_facility';
    protected $table = 'facilities';
    protected $guarded = [];

    protected $casts = [
        'facility_name' => 'json',
    ];

    public function destinations() :BelongsTo
    {
        return $this->belongsTo(Destination::class, 'id_destinasi', 'id_destinasi');
    }

    use HasFactory;
}
