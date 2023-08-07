<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_city',
        'title',
        'text',
        'rating',
        'img',
        'id_author',
    ];

    public function city() : HasOne
    {
        return $this->hasOne(City::class, 'id', 'id_city');
    }
    public function author() : HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_author');
    }
}
