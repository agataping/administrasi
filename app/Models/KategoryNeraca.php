<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoryNeraca extends Model
{
    protected $table = 'kategory_neracas';
    protected $guarded = ['id'];
    public function children(): HasMany
    {
        return $this->hasMany(KategoryNeraca::class, 'parent_id');
    }

    public function parent(): HasMany
    {
        return $this->hasMany(Neraca::class);
    }
    public function neraca()
    {
        return $this->hasMany(Neraca::class, 'parent_id');
    }
    

}
