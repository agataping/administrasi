<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenisLabarugi extends Model
{
    use HasFactory;
    protected $table = 'jenis_labarugis';
    protected $guarded = ['id'];

    
}
