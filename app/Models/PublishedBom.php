<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishedBom extends Model
{
    use HasFactory;
    protected $fillable = ['bom_id'];
}
