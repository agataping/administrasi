<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisNeraca extends Model
{
    use HasFactory;
    protected $table = 'jenis_neracas';
    protected $guarded = ['id'];

}
