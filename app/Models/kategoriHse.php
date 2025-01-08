<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategoriHse extends Model
{
    use HasFactory;
    protected $table = 'kategori_hses';
    protected $guarded = ['id'];

}
