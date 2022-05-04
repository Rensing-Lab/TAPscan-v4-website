<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supergroup extends Model
{
  protected $fillable = ['supergroup','clade_id'];
  use HasFactory;

  public function speciesTaxId()
  {
    return $this->belongsTo(SpeciesTaxId::class);
  }

  public function clade()
  {
    return $this->belongsTo(Clade::class);
  }

}
