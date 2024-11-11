<?php

// app/Models/Subcategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // Ürünler ile many-to-many ilişkisi
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_subcategory');
    }
}
