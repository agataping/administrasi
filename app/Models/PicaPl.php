<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PicaPl extends Model
{
    use HasFactory;
    protected $table = 'pica_pls';
    protected $guarded = ['id'];

}
