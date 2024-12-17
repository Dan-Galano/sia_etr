<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    // Table name
    protected $table = 'attendance';

    // Primary key
    protected $primaryKey = 'attendanceId';

    // Indicates if the primary key is auto-incrementing
    public $incrementing = true;

    // Data type of the primary key
    protected $keyType = 'int';

    // Mass assignable fields
    protected $fillable = ['post_id', 'totalAttendance'];

    // Relationships
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
