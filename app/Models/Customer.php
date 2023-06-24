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

    public function pre_sales_order(){
        return $this->hasMany('');
    }
}
