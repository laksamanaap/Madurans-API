<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $primaryKey = 'id_review';
    protected $table = 'review';
    protected $guarded = [];

      protected $fillable = [
        'id_destinasi',
        'rating',
        'description',
    ];

    public function review() :BelongsTo
    {
        return $this->belongsTo(Destination::class, 'id_review', 'id_review');
    }

    use HasFactory;
}
