<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrolledStudent extends Model
{
    use HasFactory;
    protected $table = 'enrolled_students';

    // Primary key (if it is not 'id')
    protected $primaryKey = 'studentId';

    // Indicates if the primary key is non-incrementing
    public $incrementing = false;

    // The data type of the primary key
    protected $keyType = 'string';

    // Mass assignable fields
    protected $fillable = ['studentId', 'name'];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

}
