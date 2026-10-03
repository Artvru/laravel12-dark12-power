<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseHistory extends Model
{
    protected $fillable = ['description', 'amount', 'purchase_date'];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'purchase_date' => 'date',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
