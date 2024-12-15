<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgRequiredDoc extends Model
{
    use HasFactory;

    protected $table = 'org_required_docs';

    protected $fillable = [
        'school_org_id',
        'doc_filename',
    ];

    public function schoolOrganization()
    {
        return $this->belongsTo(SchoolOrganization::class, 'school_org_id');
    }
}
