<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreSaleOrder extends Model
{
    use HasFactory;

    public function items(){
        return $this->belongsToMany(ProjectLayout::class, 'pre_sales_order_items');
    }
}
