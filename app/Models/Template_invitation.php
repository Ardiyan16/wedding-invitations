<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template_invitation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image_template',
        'link',
        'count_select',
    ];
}
