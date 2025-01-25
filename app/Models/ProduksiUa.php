<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduksiUa extends Model
{
    use HasFactory;
    protected $table = 'produksi_uas';
    protected $guarded = ['id'];

}
