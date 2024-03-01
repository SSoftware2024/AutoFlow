<?php

namespace App\Models\DrivingSchool;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'client_driving_teachers';
    protected $guarded = [];
}
