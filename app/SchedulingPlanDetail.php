<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchedulingPlanDetail extends Model
{
    public $guarded = [];

    public function schedulingPlan(){
        return $this->belongsTo(SchedulingPlan::class, "scheduling_plan_id", 'id');
    }

    public function dock()
    {
        return $this->belongsTo(Dock::class, "dock_id", 'id');
    }
}
