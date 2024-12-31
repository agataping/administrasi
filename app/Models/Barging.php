<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barging extends Model
{
    use HasFactory;
    protected $table = 'bargings';
    protected $guarded = ['id'];
}
