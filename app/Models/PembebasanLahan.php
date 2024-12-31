<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembebasanLahan extends Model
{
    use HasFactory;
    protected $table = 'pembebasan_lahans';
    protected $guarded = ['id'];
}
