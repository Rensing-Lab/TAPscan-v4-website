<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $fillable = ['family','order_id','ancestry'];
    // protected $table = 'families';
    use HasFactory;

    public function speciesTaxId()
    {
      return $this->belongsTo(SpeciesTaxId::class, 'family_id', 'family');
    }

    public function order()
    {
      return $this->belongsTo(Order::class);
    }
}
