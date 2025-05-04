<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlternativeComparisons extends Model
{
    protected $table = 'alternative_comparisons';
    protected $fillable = [
        'alternative_id','criteria_id' , 'value'
    ];
    public function alternative()
    {
        return $this->belongsTo(Alternative::class, 'alternative_id');
    }
    public function criteria()
    {
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }
}
