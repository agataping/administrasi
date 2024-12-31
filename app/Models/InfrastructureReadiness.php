<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfrastructureReadiness extends Model
{
    use HasFactory;
    protected $table = 'infrastructure_readinesses';
    protected $guarded = ['id'];

}
