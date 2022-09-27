<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_at','customer_id',
        'items','no_of_items',
        'total','status',
        'address'
    ];

    public function User() {
        return $this->belongsTo(User::class);
    }
}
