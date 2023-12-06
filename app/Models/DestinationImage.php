<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationImage extends Model
{

    protected $primaryKey = 'id_destination_images';
    protected $table = 'destination_image';
    protected $guarded = [];

    use HasFactory;
}
