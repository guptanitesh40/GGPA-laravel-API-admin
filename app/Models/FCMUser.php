<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FCMUser extends Model
{
    use HasFactory;
    protected $table = 'fcm_users';
}
