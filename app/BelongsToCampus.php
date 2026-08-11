<?php

namespace App;

trait BelongsToCampus
{
    protected static function bootBelongsToBranch() {
        // Automatically set campus_id when creating model
        static::creating(function ($model) {
            if (auth()->check() && !auth()->user()->hasRole('Super Admin')) {
                $model->campus_id = auth()->user()->campus_id;
            }
        });

        // Automatically filter data based on user campus_id
        static::addGlobalScope('campus_scope', function ($builder) {
            if (auth()->check() && !auth()->user()->hasRole('Super Admin')) {
                $builder->where('campus_id', auth()->user()->campus_id);
            }
        });
    }
}

 