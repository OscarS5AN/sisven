<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_id',
        'pay_mode_id',
        'date',
        'total',
        // agrega aquí otros campos que tenga tu tabla invoices
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payMode()
    {
        return $this->belongsTo(PayMode::class);
    }

    public function details()
    {
        return $this->hasMany(Detail::class);
    }
}