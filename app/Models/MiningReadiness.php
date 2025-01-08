<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiningReadiness extends Model
{
    use HasFactory;
    protected $table = 'mining_readinesses';
    protected $guarded = ['id'];
    public function kategoriMiniR()
    {
        return $this->belongsTo(KategoriMiniR::class, 'kategori','KatgoriDescription'); 
    }

}
