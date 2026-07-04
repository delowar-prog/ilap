<?php

namespace App;

trait BelongsToCampus
{
    protected static function bootBelongsToBranch() {
        // ডেটা সেভ করার সময় অটো campus_id সেট হবে
        static::creating(function ($model) {
            if (auth()->check() && !auth()->user()->hasRole('Super Admin')) {
                $model->campus_id = auth()->user()->campus_id;
            }
        });

        // ডেটা দেখার সময় অটো ফিল্টার হবে
        static::addGlobalScope('campus_scope', function ($builder) {
            if (auth()->check() && !auth()->user()->hasRole('Super Admin')) {
                $builder->where('campus_id', auth()->user()->campus_id);
            }
        });
    }
}

 