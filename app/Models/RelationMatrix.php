<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelationMatrix extends Model
{
    use HasFactory;

    protected $table = 'relation_matrix';

    protected $fillable = ['user_id', 'company_id'];
    
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];
}
