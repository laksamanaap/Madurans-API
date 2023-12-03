<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{

    protected $primaryKey = 'id_review';
    protected $table = 'review';
    protected $guarded = [];

      protected $fillable = [
        'id_destinasi',
        'id_customer',
        'id_review',
        'rating',
        'description',
    ];

    public function review() :BelongsTo
    {
        return $this->belongsTo(Destination::class, 'id_review', 'id_review');
    }

    public function users(): HasOne
    {
        return $this->hasOne(User::class, 'id_customer', 'id_customer');
    }

    use HasFactory;
}
