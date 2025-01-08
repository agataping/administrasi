<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PicaDeadline extends Model
{
    use HasFactory;
    protected $table = 'picai_dealines';
    protected $guarded = ['id'];

}
