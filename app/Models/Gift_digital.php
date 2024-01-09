<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift_digital extends Model
{
    use HasFactory;
    protected $fillable = [
        'bride_id',
        'bank_id',
        'account_number',
        'account_name'
    ];
}
