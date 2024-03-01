<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $fillable = ['order','supergroup_id','ancestry'];
  use HasFactory;

  public function speciesTaxId()
  {
    return $this->belongsTo(SpeciesTaxId::class, 'order_id', 'id');
  }

  public function supergroup()
  {
    return $this->belongsTo(Supergroup::class);
  }

  public function family()
  {
    return $this->hasOne(Family::class);
  }


}
