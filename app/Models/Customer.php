<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'address'];

    public function purchaseHistories(): HasMany
    {
        return $this->hasMany(PurchaseHistory::class)->orderByDesc('purchase_date')->orderByDesc('id');
    }
}
