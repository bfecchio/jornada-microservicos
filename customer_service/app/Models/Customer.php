<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use Uuid;
    public $increment = false;
    protected $keyType = "string";

    protected $fillable = [
        "id",
        "name",
        "email",
        "phone",
        "address",
        "city",
        "state",
        "zipcode"
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
