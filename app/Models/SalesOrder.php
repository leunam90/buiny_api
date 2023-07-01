<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    public function items(){
        return $this->belongsToMany(Project::class, 'sales_orders_items')->withPivot('quantity');
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function pre_sales_order(){
        return $this->belongsTo(PreSaleOrder::class);
    }
}
