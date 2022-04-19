<?php

namespace App\Models\Credentials;

use Parental\HasParent;

class GitlabCredential extends Credential
{
    use HasParent;
    protected $table = 'credentials';
}
