<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nft extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'token_id',
        'description',
        'price',
        'image',
        'is_mint',
    ];

}
