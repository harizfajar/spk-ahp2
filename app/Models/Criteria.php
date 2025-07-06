<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $table = 'criteria';
    protected $fillable = [
        'name','atribut'
    ];
    public function criteria1Comparisons()
    {
        return $this->hasMany(CriteriaComparisons::class, 'criteria_id_1');
    }
    public function criteria2Comparisons()
    {
        return $this->hasMany(CriteriaComparisons::class, 'criteria_id_2');
    }
    
}
