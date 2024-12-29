<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    protected $table = 'password_reset_tokens';
    protected $primaryKey ='email';
    protected $fillable = [
        'email',
        'token',
    ];
    public $incrementing = false; 
    protected $keyType = 'string';
    public $timestamps=false;
}
