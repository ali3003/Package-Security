<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VEmail extends Model
{
    protected $table = 'verify_email';
    protected $primaryKey ='email';
    protected $fillable = [
        'email',
        'code',
    ];
    public $timestamps=false;
}
