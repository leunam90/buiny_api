<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStageLayout extends Model
{
    use HasFactory;

    protected $table = 'project_layout_stage';

    public function project_layout(){
        return $this->belongsTo(ProjectLayout::class);
    }
}
