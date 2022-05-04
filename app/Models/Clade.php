<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clade extends Model
{
    protected $fillable = ['clade','kingdom_id'];
    use HasFactory;

    public function speciesTaxId()
    {
      return $this->belongsTo(SpeciesTaxId::class);
    }

    public function kingdom()
    {
      return $this->belongsTo(Kingdom::class);
    }
}
