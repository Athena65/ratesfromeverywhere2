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

    // Kategoriler ile many-to-many ilişkisi
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
}
