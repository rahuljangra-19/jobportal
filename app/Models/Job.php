<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory; 

    protected $cast = [
        'job_type' => 'array',
        'qualification' => 'array',
    ];

    public function category()
    {
        return $this->hasOne(JobCategory::class, 'id', 'job_category');
    }
    public function role()
    {
        return $this->hasOne(JobRole::class, 'id', 'job_role');
    }
    public function industry()
    {
        return $this->hasOne(JobIndustry::class, 'id', 'job_industry');
    }

    public function company()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function applied()
    {
        return $this->hasOne(AppliedJob::class, 'job_id', 'id');
    }
}
