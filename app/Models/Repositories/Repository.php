<?php

namespace App\Models\Repositories;

use App\Models\Credentials\GitlabCredential;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;

class Repository extends Model
{
    use HasFactory, HasChildren;

    protected $casts = [
        "metadata" => "array"
    ];

    protected $childTypes = [
        'gitlab' => GitlabRepository::class,
    ];
}
