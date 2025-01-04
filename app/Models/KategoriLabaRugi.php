<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriLabaRugi extends Model
{
    use HasFactory;
    protected $table = 'kategori_laba_rugis';
    protected $guarded = ['id'];
    
    public function subcategories()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function labaRugi()
    {
        return $this->hasOne(LabaRugi::class, 'Description');
    }
}
