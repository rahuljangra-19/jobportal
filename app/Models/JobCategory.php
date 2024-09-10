<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    public function jobs()
    {
        return $this->hasMany(Job::class,'job_category','id')->where('status',true);
    }
}
