<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgMemberList extends Model
{
    use HasFactory;

    // // Specify the table name if it doesn't follow Laravel's naming conventions
    // protected $table = 'org_members_list';

    // // Indicate whether the primary key is auto-incrementing
    // public $incrementing = true;

    // Specify the columns that are mass assignable
    protected $fillable = [
        'studentid',
        'organization_name',
        'fullname',
        'contact',
        'payment_status',
    ];
}
