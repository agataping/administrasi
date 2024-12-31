<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeadlineCompentsationCostumers extends Model
{
    use HasFactory;
    protected $table = 'deadline_compentsation_cs';
    protected $guarded = ['id'];
}
