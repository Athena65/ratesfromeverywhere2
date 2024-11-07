<?php

// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Ürünler ile many-to-many ilişkisi
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }

    // Alt kategoriler ile one-to-many ilişkisi
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class); //categorinin birden fazla subkategorisi var
    }
}
