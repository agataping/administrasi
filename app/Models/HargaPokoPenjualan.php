<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaPokoPenjualan extends Model
{
    use HasFactory;
    protected $table = 'harga_poko_penjualans';
    protected $guarded = ['id'];
      public function parent()
      {
          return $this->belongsTo(HargaPokoPenjualan::class, 'parent_id');
      }
  
      // Relasi ke children
      public function children()
      {
          return $this->hasMany(HargaPokoPenjualan::class, 'parent_id');
      }
}
