<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembebasanLahanCs extends Model
{
    use HasFactory;
    protected $table = 'pembebasan_lahan_cs';
    protected $guarded = ['id'];
}
