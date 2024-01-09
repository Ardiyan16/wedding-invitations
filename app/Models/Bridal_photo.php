<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bridal_photo extends Model
{
    use HasFactory;
    protected $fillable = [
        'bride_id',
        'photo_group',
        'photo_man',
        'photo_woman'
    ];
}
