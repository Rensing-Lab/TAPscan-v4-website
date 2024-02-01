<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Laravel\Scout\Searchable;

class Domain extends Model
{
    public $table = 'domain';
    protected $fillable = ['name','pfam'];
    // use HasFactory,Searchable;
    use HasFactory;
}
