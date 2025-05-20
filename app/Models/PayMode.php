<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayMode extends Model
{
    protected $fillable = [
        'name',
        'observation',
    ];

    // Si tienes relación con invoices
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}