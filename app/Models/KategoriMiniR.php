<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMiniR extends Model
{
    use HasFactory;
    protected $table = 'kategori_mini_r_s';
    protected $guarded = ['id'];
    public function miningReadiness()
    {
        return $this->hasMany(MiningReadiness::class, 'KatgoriDescription','kategori');
    }

}
