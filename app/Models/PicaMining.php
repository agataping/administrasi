<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PicaMining extends Model
{
    use HasFactory;
    protected $table = 'pica_minings';
    protected $guarded = ['id'];

}
