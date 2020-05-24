<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Uuid;
    public $increment = false;
    protected $keyType = "string";

    protected $fillable = [
        "id",
        "name",
    ];
}
