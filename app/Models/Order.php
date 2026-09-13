<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'shipping_address', 'total'];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
