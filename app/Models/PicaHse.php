<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PicaHse extends Model
{
    use HasFactory;
    protected $table = 'pica_hses';
    protected $guarded = ['id'];

}
