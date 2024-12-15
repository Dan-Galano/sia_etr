<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrolledStudent extends Model
{
    use HasFactory;

    protected $table = 'enrolled_students'; 

    // Specify which attributes are mass assignable
    protected $fillable = [
        'studentid', 'firstname', 'middlename', 'lastname', 'contact'
    ];

    // Optional: If you want to prevent Laravel from automatically managing the timestamps
    public $timestamps = false;
}
