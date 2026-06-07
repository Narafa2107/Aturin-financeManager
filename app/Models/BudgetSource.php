<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetSource extends Model
{
    // Mengizinkan kolom-kolom ini diisi data secara massal dari form
    protected $fillable = [
        'user_id',
        'source_name',
        'amount',
    ];
}