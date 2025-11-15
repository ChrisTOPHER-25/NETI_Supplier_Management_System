<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierContactNumber extends Model
{
    use HasFactory;
    protected $fillable = ['contact', 'contact_person_id'];
}
