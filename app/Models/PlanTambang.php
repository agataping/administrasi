<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanTambang extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'planTambang';
    protected $guarded = ['id'];
}
