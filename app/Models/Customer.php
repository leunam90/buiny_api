<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function address(){
        return $this->hasOne(FiscalAddress::class);
    }

    public function pre_sales_orders(){
        return $this->hasMany(PreSaleOrder::class);
    }

    public function sales_orders(){
        return $this->hasMany(SalesOrder::class);
    }
}
