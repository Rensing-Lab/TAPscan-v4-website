<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
// use Laravel\Scout\Searchable;

class SpeciesTaxId extends Model implements Searchable
{
    protected $fillable = ['name','taxid','lettercode','family_id','order_id','supergroup_id','clade_id','kingdom_id'];
    use HasFactory;

    public function family()
    {
      return $this->hasOne(Family::class, 'id', 'family_id');
    }

    public function clade()
    {
      return $this->hasOne(Clade::class);
    }

    public function kingdom()
    {
      return $this->hasOne(Kingdom::class, 'id', 'kingdom_id');
    }

    // public function kingdoms()
    // {
    //   return $this->hasMany(Kingdom::class, 'id', 'kingdom_id');
    // }

    public function supergroup()
    {
      return $this->hasOne(Supergroup::class);
    }

    public function order()
    {
      return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function taps()
    {
      return $this->hasMany(Tap::class, 'code_id');
    }

    public function getSearchResult(): SearchResult
{
    // $url = route('speciestaxid.show', $this->id);

    return new SearchResult(
        $this,
        $this->name,
        $this->id
     );
}
}
