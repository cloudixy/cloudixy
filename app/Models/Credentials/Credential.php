<?php

namespace App\Models\Credentials;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parental\HasChildren;

class Credential extends Model
{
    use HasFactory, HasChildren, SoftDeletes;

    protected $fillable = ['type', 'name', 'description', 'credentials_json', 'created_by'];

    protected $casts = [
        'credentials_json' => 'array',
    ];

    protected $childTypes = [
        'gitlab' => GitlabCredential::class,
    ];
}
