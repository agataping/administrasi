<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ewh extends Model
{
    use HasFactory;
    protected $table = 'ewhs';
    protected $guarded = ['id'];

}
