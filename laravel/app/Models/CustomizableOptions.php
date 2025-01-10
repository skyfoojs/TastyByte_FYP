<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomizableOptions extends Model
{
    use HasFactory;

    protected $table = 'customizableoptions';
    protected $primaryKey = 'customizeOptionsID';

    public $timestamps = true;

    protected $fillable = [
        'name', 'maxAmount', 'status', 'sort',
    ];

    // Define the relationship with Customizable Category.
    public function category()
    {
        return $this->belongsTo(CustomizeableCategory::class, 'customizeCategoryID', 'customizeCategoryID');
    }
}
