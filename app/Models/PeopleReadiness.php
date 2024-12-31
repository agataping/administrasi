<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeopleReadiness extends Model
{
    use HasFactory;
    protected $table = 'people_readinesses';
    protected $guarded = ['id'];

    public function getRataRataQualityPlanAttribute()
    {
        return round(($this->Quality_plan1 + $this->Quality_plan2 + $this->Quality_plan3 + $this->Quality_plan4 + $this->Quality_plan5) / 5, 0);
    }
}
