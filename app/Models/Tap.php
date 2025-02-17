<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Laravel\Scout\Searchable;

class Tap extends Model
{
    protected $fillable = ['tap_id','tap_1','tap_2','count','tap_3','code_id'];
    // use HasFactory,Searchable;
    use HasFactory;

    public function speciesTaxId()
    {
      return $this->belongsTo(SpeciesTaxId::class, 'lettercode', 'code_id');
    }

    public function sequenceId()
    {
      return $this->hasMany(Sequence::class);
    }
}
