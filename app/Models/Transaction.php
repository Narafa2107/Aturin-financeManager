<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'description',
        'category',
        'amount',
        'receipt',
        'transaction_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
