<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeadlineCompensation extends Model
{
    use HasFactory;
    protected $table = 'deadline_compensation';
    protected $guarded = ['id'];

}
