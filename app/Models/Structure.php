<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Laravel\Scout\Searchable;

class Structure extends Model
{
    public $table = 'structure';
    protected $fillable = ['family','structure_superclass', 'structure_class'];
    // use HasFactory,Searchable;
    use HasFactory;
}
