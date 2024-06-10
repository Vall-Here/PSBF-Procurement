<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'stock_quantity',
    ];

    /**
     * Get the requisitions for the product.
     */
    public function requisitions()
    {
        return $this->hasMany(Requisition::class);
    }

    /**
     * Get the purchase orders for the product.
     */
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
