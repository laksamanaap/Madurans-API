<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facilities extends Model
{

    protected $primaryKey = 'id_facility';
    protected $table = 'facilities';
    protected $guarded = [];

     protected $fillable = [
        'id_destinasi',
        'facility_name'
    ];

    protected $casts = [
        'facility_name' => 'json',
    ];

    use HasFactory;
}
