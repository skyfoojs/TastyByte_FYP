<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomizeableCategory extends Model
{
    use HasFactory;

    protected $table = 'customizablecategory';
    protected $primaryKey = 'customizeCategoryID';

    public $timestamps = true;

    protected $fillable = [
        'name', 'status', 'sort', 'singleChoose',
    ];

    // Define the relationship with Customizable Options.
    public function options()
    {
        return $this->hasMany(CustomizableOptions::class, 'customizeCategoryID', 'customizeCategoryID');
    }

    // Define the relationship with Product.
    public function product() {
        return $this->belongsTo(Product::class, 'productID', 'productID');
    }
}
