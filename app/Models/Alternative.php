<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    protected $table = 'alternatives';

    protected $fillable = [
        'name',
        'description',
    ];

    // public function criteriaComparisons()
    // {
    //     return $this->hasMany(CriteriaComparisons::class);
    // }
    public function alternativeComparisons()
    {
        return $this->hasMany(AlternativeComparisons::class, 'alternative_id');
    }
}
