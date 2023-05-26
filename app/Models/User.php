<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    public function getProfilePicAttribute($value)
    {
        if(!empty($value)) {
            return asset('uploads/images/'. $value);
        }
        return asset('uploads/images/user.png');;
    }

    public function getAdditionalAttachmentAttribute($value)
    {
        if(!empty($value)) {
            return asset('uploads/images/'. $value);
        }
        return '';
    }

    public function getEmailAttribute($value)
    {
        if(!empty($value)) {
            return $value;
        }
        return '';
    }

    public function getCodeAttribute($value)
    {
        if(!empty($value)) {
            return $value;
        }
        return '';
    }

    public function getCreatedAtAttribute($value)
    {
        if(!empty($value)) {
            return  date('d-M-Y H:i:s', strtotime($value));
        }
        return '';
    }

}
