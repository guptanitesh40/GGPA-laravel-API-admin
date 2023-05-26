<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BlogContent;


class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'blog';

    public function getImageAttribute($value)
    {
        if(!empty($value)) {
            return asset('blog-images/'. $value);
        }
        return '';
    }

}
