<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Uuid;
    public $increment = false;
    protected $keyType = "string";

    protected $fillable = [
        "id",
        "customer_id",
        "status",
        "downpayment",
        "discount",
        "delivery_fee",
        "late_fee",
        "total",
        "balance",
        "order_date",
        "return_date"
    ];

    protected $casts = [
        'downpayment' => 'float',
        'discount' => 'float',
        'delivery_fee' => 'float',
        'late_fee' => 'float',
        'total' => 'float',
        'balance' => 'float',
        'order_date' => 'date',
        'return_date' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function itemsTotal() {
        $totalItems = 0;
        foreach ($this->items as $item) {
            $totalItems += $item->product->price * $item->qtd;
        }
        return $totalItems;
    }

    public function getTotal() {
        return $this->itemsTotal() + $this->late_fee + $this->delivery_fee - $this->discount;
    }

    public function totalPayments() {
        $total=0;
        foreach($this->payments as $payment) {
            $total += $payment->amount;
        }
    }

    public function adjustBalance() {
        if($this->balance != $this->getTotal() - $this->totalPayments()) {
            $this->balance = $this->getTotal() - $this->totalPayments();
            $this->save();
        }
    }

    public function adjustTotal() {
        if($this->total != $this->getTotal()) {
            $this->total = $this->getTotal();
            $this->save();
        }
    }    
}
