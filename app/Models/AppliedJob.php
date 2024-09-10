<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedJob extends Model
{
    use HasFactory;

    public function job(){
        return $this->hasOne(Job::class,'id','job_id');
    }


    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
