<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeUnit extends Model
{
    use HasFactory;
    protected $table = 'code_unit';
    protected $guarded = ['id'];

    
}
