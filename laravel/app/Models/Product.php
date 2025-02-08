<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'productID';

    public $timestamps = true;

    protected $fillable = [
        'name', 'price', 'description', 'status', 'categoryID', 'image',
    ];

    // Define the relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryID', 'categoryID');
    }

    // Define the relationship with Inventory
    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'productID', 'productID');
    }

    public function customizableCategory() {
        return $this->hasMany(CustomizeableCategory::class, 'productID', 'productID')->with('options');
    }
}
