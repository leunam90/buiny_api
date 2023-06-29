<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'project';

    public function sales_orders(){
        return $this->belongsToMany(SaleOrder::class, 'sales_orders_items');
    }
}
