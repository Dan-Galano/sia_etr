<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_organization_id', 
        'officer_first_name', 
        'officer_last_name', 
        'position', 
        'officer_contact', 
        'photo',
        'is_current',
        'term_start', 
        'term_end'
    ];

}
