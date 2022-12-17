<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['id','company_name',];
    protected $hidden = ['created_at','updated_at', 'deleted_at'];
}
