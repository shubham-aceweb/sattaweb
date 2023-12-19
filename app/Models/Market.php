<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
   	protected $table = 'lottery_name_master';
   	protected $guarded = [];

   	protected static function boot()
    {
        parent::boot();

        Market::creating(function ($model) {
            $model->position = Market::max('position') + 1;
        });
    }
}
