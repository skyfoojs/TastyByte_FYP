<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'orderID';

    public $timestamps = true;

    protected $fillable = [
        'userID', 'tableNo', 'remark', 'status', 'totalAmount',
    ];

    // Define the relationship with Users
    public function user()
    {
        return $this->belongsTo(User::class, 'orderID', 'orderID');
    }

    // Define the relationship with OrderItems
    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'orderID', 'orderID');
    }

    public function payment() {
        return $this->belongsTo(Payment::class, 'paymentID', 'paymentID');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'orderID', 'orderID');
    }
}
