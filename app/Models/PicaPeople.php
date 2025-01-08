<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PicaPeople extends Model
{
    use HasFactory;
    protected $table = 'pica_people';
    protected $guarded = ['id'];

}
