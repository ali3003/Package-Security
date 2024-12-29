<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordStorage extends Model
{

        protected $table = 'password_storage';
        protected $fillable = [
            'user_id',
            'name',
            'description',
            'password',
        ];
}
