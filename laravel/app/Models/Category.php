<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $primaryKey = 'categoryID';

    public $timestamps = true;

    protected $fillable = [
        'name', 'status', 'sort',
    ];

    // Define the relationship with Product
    public function products()
    {
        return $this->hasMany(Product::class, 'categoryID', 'categoryID');
    }
}
