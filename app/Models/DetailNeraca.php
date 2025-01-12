<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailNeraca extends Model
{
    use HasFactory;
    protected $table = 'detail_neracas';
    protected $guarded = ['id'];


}
