<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    protected $primaryKey = 'paymentID';

    public $timestamps = true;

    protected $fillable = [
        'voucherID', 'orderID', 'totalAmount', 'paymentMethod', 'status'
    ];

    public function vouchers()  {
        return $this->hasOne(Vouchers::class, 'voucherID', 'voucherID');
    }

    public function orders() {
        return $this->hasOne(Orders::class, 'orderID', 'orderID');
    }
}
