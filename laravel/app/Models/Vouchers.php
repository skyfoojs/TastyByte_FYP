<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model
{
    use HasFactory;

    protected $table = 'vouchers';
    protected $primaryKey = 'voucherID';

    public $timestamps = true;

    protected $fillable = [
        'code', 'type', 'singleUse', 'usage', 'value', 'startedOn', 'expiredOn', 'usedCount',
    ];

    public function payment()  {
        return $this->belongsTo(Payment::class, 'paymentID', 'paymentID');
    }
}
