<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationMaterialImage extends Model
{
    use HasFactory;
    protected $fillable = ['material_id', 'file_name'];
}
