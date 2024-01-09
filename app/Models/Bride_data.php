<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bride_data extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_invitation',
        'slug',
        'template_id',
        'name_groom',
        'name_bride',
        'link_instagram_man',
        'link_instagram_woman',
        'wedding_date',
        'wedding_time',
        'akad_date',
        'akad_time',
        'quote',
        'quote_resource',
        'son_to',
        'man_name_parent1',
        'woman_name_parent1',
        'daughter_to',
        'man_name_parent2',
        'woman_name_parent2',
        'address_akad',
        'link_address_akad',
        'address_wedding',
        'link_address_wedding',
        'second_address',
        'link_second_address'
    ];
}
