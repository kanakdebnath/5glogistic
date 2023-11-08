<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ManageCategory extends Model
{
    protected $guarded = ['id'];


    public function getStatusMessageAttribute()
    {
        if ($this->status == 0) {
            return '<span class="badge badge-warning">' . trans('In-active') . '</span>';
        }
        return '<span class="badge badge-success">' . trans('Active') . '</span>';
    }

    public function getCapitalBackMessageAttribute()
    {
        if ($this->capital_back == 0) {
            return '<span class="badge badge-warning">' . trans('No') . '</span>';
        }
        return '<span class="badge badge-success">' . trans('Yes') . '</span>';
    }

    public function plans()
    {
        return $this->hasMany(ManagePlan::class, 'category_id');
    }
}