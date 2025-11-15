<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomMaterial extends Model
{
    use HasFactory;
    protected $fillable = ['quantity', 'name', 'brand', 'unit', 'description', 'category_id', 'bom_id'];
}
