<?php

namespace App\Models;
// test push
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationMember extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'organization_id',
        'member_id',
        'is_admin',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function organization()
    {
        return $this->belongsTo(SchoolOrganization::class, 'organization_id');
    }
}
