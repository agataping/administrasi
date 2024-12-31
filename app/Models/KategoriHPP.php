<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriHPP extends Model
{
    use HasFactory;
    protected $table = 'kategori_h_p_p_s';
    protected $guarded = ['id'];
    public function getLevelAttribute()
    {
        $level = 0;
        $parent = $this->parent;
        
        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }
    
        return $level;
    }

    public function parent()
    {
        return $this->belongsTo(KategoriHPP::class, 'parent_id');
    }
    
    public function children()
    {
        return $this->hasMany(KategoriHPP::class, 'parent_id');
        
}
}
