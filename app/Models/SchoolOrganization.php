<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use App\Models\User;


// class SchoolOrganization extends Model
// {
//     use HasFactory;
//     protected $table = 'school_organizations';
//     protected $fillable = [
//         'orgname',
//         'course',
//         'bio',
//         'contact',
//         'facebook',
//         'instagram',
//         'twitter',
//         'tiktok',
//         'youtube',
//         'coverphoto',
//         'admin_id',
//     ];

//     public function admin()
//     {
//         return $this->belongsTo(User::class, 'admin_id');
//     }

//     public function members()
//     {
//         return $this->hasMany(OrganizationMember::class, 'organization_id');
//     }

//     public function posts()
//     {
//         return $this->hasMany(Post::class, 'organization_id');
//     }

//     public function chats()
//     {
//         return $this->hasMany(Chat::class, 'organization_id');
//     }
// }



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SchoolOrganization extends Model
{
    use HasFactory;
    
    protected $table = 'school_organizations';

    protected $fillable = [
        'orgname',
        'course',
        'bio',
        'contact',
        'facebook',
        'instagram',
        'twitter',
        'tiktok',
        'youtube',
        'coverphoto',
        'admin_id',
        'status',
        'mission',
        'vision'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function members()
    {
        return $this->hasMany(OrganizationMember::class, 'organization_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'organization_id');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'organization_id');
    }

    public function requiredDocuments()
    {
        return $this->hasMany(OrgRequiredDoc::class, 'school_org_id');
    }
}
