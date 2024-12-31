<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neraca extends Model
{
    use HasFactory;
    protected $table = 'neracas';
    protected $guarded = ['id'];
    public function Kategori(): BelongsTo
    {
        
        return $this->belongsTo(KategoryNeraca::class, 'parent_id');    
    }
    public function Datakategori(): BelongsTo
    {
        
        return $this->belongsTo(KategoryNeraca::class);    
    }

    
}
