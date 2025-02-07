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
        'orderID', 'productID', 'quantity', 'remark'
    ];

    public function orders()
    {
        return $this->belongsTo(Orders::class, 'orderID');
    }
}
