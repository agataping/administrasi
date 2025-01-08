<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PicaPaUa extends Model
{
    use HasFactory;
    protected $table = 'pica_pa_uas';
    protected $guarded = ['id'];

}
