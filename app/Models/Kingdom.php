<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kingdom extends Model
{
  protected $fillable = ['kingdom'];
  use HasFactory;

  public function speciesTaxId()
  {
    return $this->belongsTo(SpeciesTaxId::class, 'kingdom_id', 'id');
  }

  public function clade()
  {
    return $this->hasMany(Clade::class, 'kingdom_id', 'id');
  }
}
