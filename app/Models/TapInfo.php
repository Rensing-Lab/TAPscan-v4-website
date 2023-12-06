<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Laravel\Scout\Searchable;

class TapInfo extends Model
{
    protected $fillable = ['tap','text','reference','type'];
    // use HasFactory,Searchable;
    use HasFactory;
}
