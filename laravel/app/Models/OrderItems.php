<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    protected $table = 'orderitems';
    protected $primaryKey = 'orderItemID';

    public $timestamps = true;

    protected $fillable = [
        'orderID', 'productID', 'quantity', 'remark', 'status'
    ];

    public function orders()
    {
        return $this->belongsTo(Orders::class, 'orderID');
    }

    public function products() {
        return $this->belongsTo(Product::class, 'productID');
    }

    public function table(){
        return $this->belongsTo(Orders::class, 'orderID');
    }
}
