<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sequence extends Model
{
  protected $fillable = ['tap_id','sequence'];
  use HasFactory;

  public function tapId()
  {
    return $this->belongsTo(Tap::class);
  }
}
