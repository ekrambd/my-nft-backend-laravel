<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nft_id',
        'token_id',
        'contract_address',
        'wallet_address',
        'mint_price',
        'transaction_hash',
        'status',
        'date',
        'time',
    ];

}
