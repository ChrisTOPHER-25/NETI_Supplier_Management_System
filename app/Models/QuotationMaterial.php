<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationMaterial extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantity', 
        'name', 
        'brand', 
        'unit', 
        'description', 
        'unit_price',
        'category_id',
        'quotation_id',
    ];
}
