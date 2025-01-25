<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PicaEwhFuel extends Model
{
    use HasFactory;
    protected $table = 'pica_ewh_fuels';
    protected $guarded = ['id'];

}
