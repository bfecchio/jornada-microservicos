<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use Uuid;
    public $increment = false;
    protected $keyType = "string";

    protected $fillable = [
        "id",
        "order_id",
        "payment_type",
        "description",
        "amount",
        "payment_date",
    ];

    protected $casts = [
        'amount' => 'float',
        'payment_date' => 'date'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }    
}
