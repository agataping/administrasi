<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PicaBarging extends Model
{
    use HasFactory;
    protected $table = 'pica_bargings';
    protected $guarded = ['id'];

}
