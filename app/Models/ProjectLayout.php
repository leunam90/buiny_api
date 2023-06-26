<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLayout extends Model
{
    use HasFactory;

    protected $table = 'project_layout';

    public function stages(){
        return $this->hasMany(ProjectStageLayout::class, 'project_id');
    }

    public function pre_sales(){
        return $this->belongsToMany(PreSaleOrder::class, 'pre_sales_orders_items');
    }
}
