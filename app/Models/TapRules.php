<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class TapRules extends Model implements Searchable
{
    protected $fillable = ['tap_1','tap_2','rule'];
    use HasFactory;

    public function getSearchResult(): SearchResult
{
    // $url = route('categories.show', $this->id);

    return new SearchResult(
        $this,
        $this->tap_1,
        $this->id
        // $url
     );
}
}
