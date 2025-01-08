<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockJt extends Model
{
    use HasFactory;
    protected $table = 'stock_jts';
    protected $guarded = ['id'];

}
