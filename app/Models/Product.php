<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Toplu atamaya izin verilen alanlar
    protected $fillable = [
        'name',
        'description',
        'image',
        'site_rating',
        'global_rating'
    ];
}
