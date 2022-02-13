<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maker extends Model
{
    protected $guarded = ['id'];
    protected $fillable = ['name','country','person_in_charge','address'];
}

