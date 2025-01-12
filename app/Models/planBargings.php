<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class planBargings extends Model
{
    use HasFactory;
    protected $table = 'plan_bargings';
    protected $guarded = ['id'];

    
}
