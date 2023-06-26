<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreSaleOrder extends Model
{
    use HasFactory;

    protected $table = 'pre_sales_orders';

    public function items(){
        return $this->belongsToMany(ProjectLayout::class, 'pre_sales_orders_items')->withPivot('quantity');
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
