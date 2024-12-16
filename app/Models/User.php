<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
// use App\Models\SchoolOrganization;

// use Illuminate\Support\Carbon;

// class User extends Authenticatable
// {
//     use HasApiTokens, HasFactory, Notifiable;

//     /**
//      * The attributes that are mass assignable.
//      *
//      * @var array<int, string>
//      */
//     protected $fillable = [
//         'type',
//         'studentid',
//         'firstname',
//         'middlename',
//         'lastname',
//         'email',
//         'photo',
//         'password',
//     ];

//     /**
//      * The attributes that should be hidden for serialization.
//      *
//      * @var array<int, string>
//      */
//     protected $hidden = [
//         'password',
//         'remember_token',
//     ];

//     /**
//      * The attributes that should be cast.
//      *
//      * @var array<string, string>
//      */
//     protected $casts = [
//         'email_verified_at' => 'datetime',
//         'password' => 'hashed',
//     ];


// public function schoolOrganizations()
// {
//     return $this->hasMany(SchoolOrganization::class, 'admin_id');
// }

// public function organizationsMember()
// {
//     return $this->belongsToMany(SchoolOrganization::class, 'organization_members', 'member_id', 'organization_id')
//                 ->withPivot('status')
//                 ->withTimestamps();
// }


//     public function memberships()
//     {
//         return $this->hasMany(OrganizationMember::class, 'member_id');
//     }

//     public function posts()
//     {
//         return $this->hasMany(Post::class);
//     }

//     public function comments()
//     {
//         return $this->hasMany(Comment::class);
//     }

//     public function reactions()
//     {
//         return $this->hasMany(Reaction::class);
//     }

//     public function chats()
//     {
//         return $this->hasMany(Chat::class);
//     }

   
// }



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\SchoolOrganization;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'type',
        'studentid',
        'firstname',
        'middlename',
        'lastname',
        'email',
        'photo',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function schoolOrganizations()
    {
        return $this->hasMany(SchoolOrganization::class, 'admin_id');
    }

    public function organizationsMember()
    {
        return $this->belongsToMany(SchoolOrganization::class, 'organization_members', 'member_id', 'organization_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function memberships()
    {
        return $this->hasMany(OrganizationMember::class, 'member_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}