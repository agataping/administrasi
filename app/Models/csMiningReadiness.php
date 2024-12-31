<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class csMiningReadiness extends Model
{
    use HasFactory;
    protected $table = 'cs_mining_readinesses';
    protected $guarded = ['id'];

}
