<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        // agrega aquí otros campos que tenga tu tabla customers
    ];

    // Si tienes relación con invoices
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}