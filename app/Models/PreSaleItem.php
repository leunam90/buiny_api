<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreSaleItem extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'pre_sales_orders_id', 'item_id'];
}
